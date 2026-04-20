# SmartShop Mini — AI-Powered Product Recommender
**Task Breakdown**

## Phase 1: Database & Models
- [x] Create `Product` model with fillable properties and casts.
- [x] Create `create_products_table` migration.
- [x] Create `ProductFactory` with realistic Faker data.
- [x] Create `ProductSeeder` to generate 20-30 products.

## Phase 2: Core Services & Logic
- [x] Implement `RecommendationService`:
  - `getRecommendations(array $viewedProductIds)` method.
  - Implement OpenAI API call with JSON response parsing.
  - Implement fallback logic for when AI fails or no products are viewed.

## Phase 3: Controllers & Routing
- [x] Set up `routes/web.php` for Home, Product, and Cart pages.
- [x] Implement `HomeController`:
  - Fetch all products.
  - Fetch recommendations via `RecommendationService`.
- [x] Implement `ProductController`:
  - Fetch single product by slug.
  - Add logic to track product in `recently_viewed` session array.
- [x] Implement `CartController`:
  - `index()` to view cart.
  - `add()` to insert item to session cart.
  - `update()` to change quantity.
  - `remove()` to delete item from session cart.

## Phase 4: Frontend Implementation (Blade + Tailwind + Alpine)
- [x] Create main layout `resources/views/components/layouts/app.blade.php`.
- [x] Create `home.blade.php` with product grid and recommendations section.
- [x] Create `products/show.blade.php` with product details and "Add to Cart" Alpine form.
- [x] Create `cart/index.blade.php` to list cart items and total.

## Phase 5: Verification
- [x] Run Pint, PHPStan.
- [x] Verify N+1 queries using Laravel Telescope or standard DB listening (ensure zero N+1).
- [x] Test AI fallback logic locally.
