<?php

namespace App\Http\Controllers;

use App\DTOs\Booking\StoreDTO;
use App\DTOs\Booking\UpdateDTO;
use App\Http\Requests\Booking\Createrequest;
use App\Http\Requests\Booking\Updaterequest;
use App\Models\Booking;
use App\Services\Bookingservice;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Cache;
use Throwable;

#[Group('BOOKING')]
/**
 * @group Authentication
 */
class Bookingcontroller extends Controller
{
    public function __construct(
        private Bookingservice $bookingService
    ) {}
    /**
     * ALL BOOKINGS
     */
    public function index()
    {
        //
        try{
        $booking_list=$this->bookingService->index();
        return response()->json([
            'success' => true,
            'message' => 'Booking list fetched successfully.',
            'data'=>$booking_list->items(),
            'pagination' => paginate_extractor($booking_list)

        ], 200);
        }
        catch(Throwable $e){
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ]);
        }
    }

    /**
     * CREATE BOOKING
     * 
     */
    public function store(Createrequest $request)
    {
        //
        try{
        $dto = StoreDTO::fromRequest($request);
        $booking = $this->bookingService->store($dto);
        return response()->json([
            'success'=>true,
            'message' => 'Booking created successfully.',
            'data' => $booking,
        ], 201);
        
        }catch(\Throwable $e){
            return response()->json([
                'success'=>false,
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    /**
     * SHOW SPECIFIC BOOKING
     */
    public function show(string $id)
    {
        //
        try{
        $booking = Booking::findOrFail($id);
        $this->authorize('view', $booking);
        // return auth()->user();
        $booking = $this->bookingService->show($id);
        return response()->json([
            'success' => true,
            'message' => 'Booking fetched successfully.',
            'data' => $booking,
        ], 200);}
        catch(\Throwable $e){
            return response()->json([
                'success'=>false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updaterequest $request, string $id)
    {
        try {
            $booking = Booking::findOrFail($id);

            $this->authorize('update', $booking);

            $dto = UpdateDTO::fromRequest($request);

            $booking = $this->bookingService->update($dto, $id);

            return response()->json([
                'success' => true,
                'message' => 'Booking updated successfully.',
                'data' => $booking,
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
