# SmartShop Mini — AI-Powered Product Recommender
**Technical Plan**

## 1. Architectural Overview
This system is built on Laravel 12 using a minimalistic Model-View-Controller (MVC) architecture. It purposefully avoids over-engineered patterns (like repositories or complex service layers for standard CRUD) in favor of Laravel's built-in conventions. 

- **Frontend**: Blade components + Tailwind CSS v4 + Alpine.js.
- **Backend**: Laravel PHP 8.4+. 
- **Database**: SQLite (or whatever default DB is configured), containing only a `products` table.
- **State Management**: Session-based cart and recently viewed products.

## 2. Component Analysis (Starter Template)
- **Keep**: The standard Laravel routing (`web.php`), Blade templating engine, Tailwind CSS setup. 
- **Remove**: Since this is a minimal store without user authentication, we will not utilize Fortify or any authentication-related boilerplate that may exist in the starter template. 
- **Add**: 
  - `Product` model, migration, factory, and seeder.
  - `RecommendationService` for interacting with the AI.
  - Controllers for Home, Product, and Cart functionality.
  - Blade views for the 3 distinct pages.

## 3. Data Models
### `Product` Model
- `id` (PK)
- `name` (string)
- `slug` (string, unique)
- `description` (text)
- `price` (integer, stored in cents to avoid float rounding errors, cast to float on access)
- `image_url` (string, URL to a placeholder image)

## 4. Business Logic Design
### Session Cart Management
The cart will be an array stored in the session under the key `cart`. 
Structure:
```php
[
    1 => ['product' => ProductModel, 'quantity' => 2],
    4 => ['product' => ProductModel, 'quantity' => 1]
]
```

### Recently Viewed Products
Stored in the session under the key `recently_viewed`. It will be an array of product IDs, capped at 3 items. Whenever a user visits a product page, the ID is prepended to the array, and the array is sliced to 3 elements.

### Recommendation Engine (`RecommendationService`)
- **Input**: Array of recently viewed product IDs.
- **Process**:
  1. Fetch the corresponding products.
  2. If the user hasn't viewed any products, return 3 random products.
  3. If they have viewed products, construct a prompt containing the viewed products' context (names, descriptions).
  4. Send prompt to OpenAI (or mock the AI response for this prototype to guarantee speed/reliability, given this is a local setup and no API key is guaranteed). *Note: We will implement the actual HTTP call to OpenAI, but with a fast try/catch fallback to random products if the API key is missing or the request fails.*
- **Output**: Collection of 3 recommended `Product` models.

## 5. Security & Performance Considerations
- **N+1 Queries**: Ensure `Product::all()` or random queries are properly structured. In our case, the `Product` model has no relations, so N+1 is inherently avoided.
- **Session Security**: Laravel's default encrypted sessions handle tampering.
- **Validation**: Strict Form Request validation for adding items to the cart (validating product exists, quantity is an integer > 0).

## 6. Code Quality Standards
- Strict type hinting for all parameters and return types.
- Follow Laravel Boost guidelines and Pint formatting.
- Thin controllers: AI logic is abstracted to `RecommendationService`.
