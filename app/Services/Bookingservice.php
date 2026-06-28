<?php
namespace App\Services;

use App\DTOs\Booking\StoreDTO;
use App\DTOs\Booking\UpdateDTO;
use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class Bookingservice{
    protected $user;

    public function __construct(){
        $this->user = auth()->user();
    }

    public function index(){
        $page = request('page', 1);
        Cache::tags(['booking'])->flush();
        $booking_list = Cache::tags(['booking'])->remember(
            'booking_list'.$this->user->hotel_id.$page,
            7200,
            function () {
                return Booking::join('customers', 'bookings.customer_id', '=', 'customers.id')
                ->select('bookings.id as id','bookings.status as status','bookings.party_size as size','bookings.booked_at as time','bookings.reservation_at as date','customers.name as customer_name','customers.phone as customer_phone')->where('bookings.hotel_id', $this->user->hotel_id)
                ->paginate(2);
            }
        );
        return $booking_list;
    }

    public function show($id){
            return Cache::tags(['booking'])->remember(
                'booking_'.$id,
                7200,
                function () use ($id) {
                    return Booking::join('customers', 'bookings.customer_id', '=', 'customers.id')
                        ->select(
                            'bookings.*',
                            'customers.name as customer_name',
                            'customers.phone as customer_phone'
                        )
                        ->where('bookings.id', $id)
                        ->first();
                }
            );
    }

    public function Customer_check(StoreDTO $dto){
        $phone = '+91'.$dto->phone;
        $customer = Customer::firstOrCreate(
            ['phone' => $phone],
            [
                'name' => $dto->name,
                'email' => $dto->email,
                'password' => Hash::make('12345678'),
            ]
        );

        if ($customer->wasRecentlyCreated) {
            Log::channel('booking')->info('New customer created.', [
                'customer_id' => $customer->id,
            ]);
            // NEED TO CHANGE FLUSH
            Cache::tags(['customer'])->flush();
        } else {
            Log::channel('booking')->info('Existing customer found.', [
                'customer_id' => $customer->id,
            ]);
        }
        return $customer;
    }
    public function store(StoreDTO $dto){
        return DB::transaction(function () use ($dto) {
            $customer = $this->Customer_check($dto);
            $booking = $customer->bookings()->create([
                'hotel_id'=>$this->user->hotel_id,
                'table_id'=>$dto->table_id??null,
                'pqueue_id'=>$dto->pqueue_id??null,
                'customer_id'=>$customer->id,
                'party_size' => $dto->party_size,
                'status' => $dto->status,
                'booking_type' => $dto->booking_type,
                'reservation_at' => $dto->reservation_at??null,
                'booked_at' => now(),
                'seated_at'      => $dto->status === 'seated' ? now() : null,
            ]);
            Log::channel('booking')->info('Booking created successfully.', [
            'booking_id' => $booking->id,
            'customer_id' => $customer->id,
            'hotel_id' => $this->user->hotel_id,
            'phone' => $customer->phone,
            'created_by' => $this->user->id,
            ]);
            Cache::tags(['booking'])->forget('booking_list'.$this->user->hotel_id);
            return $booking;
        });
    }
    public function update(UpdateDTO $dto, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => $dto->status,
            'party_size' => $dto->party_size,
            'reservation_at' => $dto->reservation_at,
            'table_id' => $dto->table_id,
        ]);
        // clear single booking cache
        Cache::tags(['booking'])->forget('booking_' . $id);

        // also clear list cache (IMPORTANT)
        Cache::tags(['booking'])->flush();
        return $booking;
    }
}
?>