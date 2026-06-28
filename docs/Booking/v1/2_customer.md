# Customer

## `customers`

| Field | Type | Required | Notes |
|-------|------|----------|-------|
| id | uuid | ✅ | Primary key |
| mobile_number | string | ✅ | Unique |
| name | string | ✅ | |
| email | string | ❌ | Unique if provided — future login ready |
| created_at | timestamp | ✅ | |

---

## `p_queues`

| Field | Type | Required | Notes |
|-------|------|----------|-------|
| id | uuid | ✅ | Primary key |
| hotel_id | uuid FK | ✅ | → hotels.id |
| customer_id | uuid FK | ✅ | → customers.id |
| position | int | ✅ | Queue order, lowest = next |
| guest_count | int | ✅ | |
| status | enum | ✅ | `waiting`, `seated`, `cancelled` |
| joined_at | timestamp | ✅ | |
| seated_at | timestamp | ❌ | Set when converted to booking |

---

## `bookings`

| Field | Type | Required | Notes |
|-------|------|----------|-------|
| ... | | | |
| customer_id | uuid FK | ✅ | → customers.id |
| p_queue_id | uuid FK | ❌ | → p_queues.id — null if direct booking |
| ... | | | |

---

## Relationships

- A **customer** can have many **p_queue** entries and many **bookings**
- A **p_queue** entry belongs to one customer
- A **booking** belongs to one customer
- A booking created from a queue sets `p_queue_id` — direct bookings leave it null