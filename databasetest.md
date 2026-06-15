users
- id (uuid)
- name, email, password...
- full_name, phone, address, birth, avatar
- role (user/admin)

brands
- id, name, logo, country, description

cars
- id (uuid)
- brand_id
- name, slug
- price, year, color, type, quantity, mileage
- fuel_type, transmission, engine_capacity, seats
- description, status, featured_image
- views, created_at, updated_at

car_images
- id, car_id, img_url, sort_order

cart_items
- id
- user_id
- car_id
- quantity
- price (giá tại thời điểm thêm)

orders
- id
- user_id
- total_amount
- status, payment_method, payment_status
- customer_full_name, phone, address
- created_at

order_items
- id
- order_id
- car_id
- quantity
- price