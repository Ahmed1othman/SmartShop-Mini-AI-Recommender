# SmartShop Mini — Implementation Design

## 1. Architecture Design

*   **Core Paradigm**: The system follows a minimalistic Model-View-Controller (MVC) architecture designed specifically for a lightweight e-commerce prototype. It relies on foundational framework layers without introducing unnecessary abstractions like Repositories or Command Buses, ensuring a low cognitive load for reviewers.
*   **Data Layer (Model)**: Represents the database entities. For this minimal viable product, it only includes the product entity. All data retrieval relies on the built-in ORM.
*   **Routing & Controller Layer**: Routes incoming HTTP requests to specific controller methods. Controllers act as thin orchestrators, delegating complex domain logic to dedicated services and state management to built-in session handlers.
*   **Service Layer**: Houses external API integrations and complex domain logic. Specifically, this isolates the AI recommendation engine so the controllers remain clean, focused, and testable.
*   **Presentation Layer (View)**: Utilizes server-side rendered templates integrated with utility-first CSS for styling and a lightweight JavaScript framework for client-side interactivity, specifically handling asynchronous cart interactions without full page reloads.
*   **State Management (Session)**: All user-specific state—including the shopping cart and recently viewed product history—is maintained entirely in the server-side session. This eliminates the need for user authentication or database-backed cart tables for anonymous users.

---

## 2. Step-by-step Implementation Plan

*   **Step 1: Domain Modeling & Database Setup**
    *   **What needs to be created**: Database migration, model, factory, and seeder for the product entity.
    *   **Why this order matters**: The foundational data structure must exist before any routing, controllers, or views can be built. Seeded data is crucial for testing the UI and ensuring the AI recommendations have actual products to suggest.

*   **Step 2: Service Layer Construction**
    *   **What needs to be created**: The AI recommendation service class.
    *   **Why this order matters**: The core unique feature of the project (AI recommendations) should be built and isolated early so that controllers can easily consume it once they are created.

*   **Step 3: State Management & Controllers**
    *   **What needs to be created**: Controllers for the home page, product details, and the shopping cart.
    *   **Why this order matters**: The controllers bind the data layer and service layer together, managing the session state (viewed items, cart items) before passing data to the presentation layer.

*   **Step 4: Presentation Layer Integration**
    *   **What needs to be created**: The layout template and individual page templates for the home, product, and cart views.
    *   **Why this order matters**: The user interface is the final step, consuming the data prepared by the controllers and providing the interactive layer for the user.

---

## 3. Pseudo Structure

*   **ProductModel**
    *   responsibility: Represents a product in the database, maps column names, and provides accessors for formatting (e.g., price display).

*   **HomeController**
    *   responsibility: Orchestrates the landing page data.
    *   methods:
        *   renderIndexPage()

*   **ProductController**
    *   responsibility: Orchestrates individual product views and session tracking.
    *   methods:
        *   renderProductPage()
        *   trackRecentlyViewedProduct()

*   **CartController**
    *   responsibility: Manages the shopping cart session array.
    *   methods:
        *   renderCartPage()
        *   addItemToCart()
        *   updateItemQuantity()
        *   removeItemFromCart()

*   **RecommendationService**
    *   responsibility: Handles communication with the AI provider to suggest products based on viewing history.
    *   methods:
        *   fetchRecommendations()
        *   buildAiPrompt()
        *   parseAiResponse()
        *   fetchRandomFallbackProducts()

---

## 4. Data Flow Explanation

*   **User Navigation Flow**:
    *   The user lands on the Home Page. The system retrieves all available products from the database and calls the recommendation service to populate the suggestions section.
    *   The user clicks on a product, navigating to the Product Details Page.
    *   The system retrieves the product details and triggers the recently viewed tracking logic.

*   **Session Usage Flow**:
    *   **Recently Viewed**: When a user views a product, the product identifier is pushed to the front of a session array. The array is then truncated to keep only the three most recent unique identifiers.
    *   **Cart**: When a user adds an item, the system checks the cart session array. If the item exists, its quantity is incremented. If not, a new entry is created with the product details and initial quantity.

*   **AI Request Flow**:
    *   The recommendation service reads the recently viewed identifiers from the session.
    *   If the array contains items, the service retrieves the corresponding product context (names, descriptions).
    *   The service constructs a structured prompt containing the viewed context and a list of all available product names/identifiers.
    *   The service sends the prompt to the external AI provider.
    *   The AI provider returns a list of suggested product identifiers.
    *   The service maps these identifiers back to product entities and returns them to the controller.

*   **Fallback Logic Flow**:
    *   If the recently viewed session array is empty, the service bypasses the AI request and immediately returns three random products from the database.
    *   If the AI request times out, fails, or returns malformed data, the system catches the exception and seamlessly falls back to the random product retrieval strategy, ensuring the user always sees recommendations without encountering errors.
