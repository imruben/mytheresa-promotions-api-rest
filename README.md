# MyTheresa API Promotions Assigment

## Getting Started

To get started with this project, follow these steps:

1. **Install Make** (if you don't have it installed already):
    - For Linux (using `apt`):
      ```bash
      sudo apt install make
      ```
    - For macOS (using `brew`):
      ```bash
      brew install make
      ```
    - For Windows, you can use the [Make for Windows](https://sourceforge.net/projects/gnuwin32/) or WSL (Windows Subsystem for Linux).

2. **Start the Docker containers**:
    ```bash
    make start
    ```

   This will:
    - Build and start the necessary Docker containers.
    - Set up the application environment.

### Run tests

Once the containers are up and running, you can run the tests with:

```bash
  make test
```

## API Documentation

### `/products` Endpoint

The `/products` endpoint is used to fetch a list of products with applied promotions. You can filter the products based on various query parameters.

#### Request Example

A typical GET request to the `/products` endpoint might look like this:

This request filters the products by the `category` and `priceLessThan` parameters.

#### Query Parameters

- **category**: (Optional) Filter the products by category. For example, "boots", "shoes", "bags", etc.
- **priceLessThan**: (Optional) Filter that applies before discounts are applied and will show products with prices lesser than or equal

#### Response Example

Here’s an example of the JSON response you might get for the above request:
    http://localhost/products?category=boots&priceLessThan=90000

```json
{
  "products": [
    {
      "sku": "000001",
      "name": "BV Lean leather ankle boots",
      "category": "boots",
      "price": {
        "original": 89000,
        "final": 62299,
        "discount_percentage": "30%",
        "currency": "EUR"
      }
    },
    {
      "sku": "000003",
      "name": "Ashlington leather ankle boots",
      "category": "boots",
      "price": {
        "original": 71000,
        "final": 49700,
        "discount_percentage": "30%",
        "currency": "EUR"
      }
    }
  ]
}

