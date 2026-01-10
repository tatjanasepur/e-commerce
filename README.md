E-commerce Cart App

This is a simple Laravel + Livewire e-commerce app built as a part of a technical task.

Users can:
- Register and log in
- View products
- Add products to a cart
- Increase / decrease quantity
- Remove items from cart
- See the total price
The app also checks product stock when adding items to the cart.
 Tech stack
- Laravel
- Livewire (Volt)
- MySQL (or SQLite)
- Tailwind CSS
Setup
1. Clone the repository
git clone https://github.com/tatjanasepur/e-commerce.git  
cd e-commerce  
2. Install dependencies
composer install  
npm install  
3. Create environment file
cp .env.example .env  
4. Generate app key
php artisan key:generate  
5. Configure database in `.env`  
(you can use MySQL or SQLite)
6. Run migrations and seed demo data
php artisan migrate --seed  
7. Build frontend assets
npm run dev  
8. Start the server
php artisan serve  
Open in browser:  
http://127.0.0.1:8000
Test user

You can register a new account, or use a seeded one if needed.

Products are seeded automatically:
- Mechanical Keyboard
- Wireless Mouse
- USB-C Cable
 Notes:
The focus of this project is the cart logic, stock handling, and authentication flow.

Checkout / payments are not implemented because they were not part of the task.
