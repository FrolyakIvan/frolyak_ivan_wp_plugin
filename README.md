# Frolyak Ivan WP Plugin

**Frolyak Ivan WP Plugin** plugin is a WordPress plugin that shows users data when a custom endpoint is visited. When visiting a custom endpoint, the plugin makes a request to an external API to obtain users data, then selects a template to display this information on the frontend. Users can interact with the data by clicking on one of the three mandatory columns (id, name or username). This will trigger an AJAX request to fetch and display additional user data and display it in the frontend template as well. All the HTTP requests are performed in the server-side.

The external API used for this implementation is [https://jsonplaceholder.typicode.com/](https://jsonplaceholder.typicode.com/).

## Requirements

- WordPress version 6.4 or higher
- PHP version 8.1 or higher

## Installation

1. Clone this repository into your WordPress `wp-content/plugins` directory.
2. Run ```composer install``` within the cloned directory to install necessary dependencies.

## Usage

When you activate the plugin, the default endpoint `custom-endpoint` becomes enabled. If desired, users can modify this via the plugin settings. To make this change, navigate to the "Frolyak Plugin Settings" in the menu and update the endpoint value as needed.


## Implementation Details

The implementation follows the object-oriented programming paradigm. Where each object corresponds to a class that performs certain functions and communicates with other classes.
There is a main class `FrolyakIvanWpPlugin` of the plugin that launches all other objects necessary for the operation of this plugin. In addition, there is a class `EndpointController` that intercommunicates different components or classes so that the flow can be managed in a centralized way.

The implementation primarily consists of six components:

- **FrolyakIvanWpPlugin Class**: The main class of the plugin, responsible for initializing key components and managing the activation and deactivation of the plugin.
- **EndpointController Class**: Serves as the central class that manages and communicates with other classes or objects. It is responsible for loading styles and scripts, adding rewrite rules, handling AJAX calls, etc.
- **APIService Class**: Handles the execution of HTTP requests and parsing the obtained results.
- **CacheHandler Class**: Responsible for managing the caching of HTTP requests.
- **ViewController Class**: Designed with a "Skeleton" approach, this class is responsible for returning the correct template to the defined endpoint and also save the obtained data from the request.
- **AdminController Class**: This class is in charge of adding a new option to the wordpress admin menu and a corresponding plugin configuration page. Where the user can change the value of the endpoint.

### Use of WordPress Transients for HTTP Cache

The decision to use WordPress transients for HTTP response caching is because their ease of use and efficiency. Transients provide a native, user-friendly architecture for temporarily storing cached data in the database, that decreases the demand on external APIs and increases response speeds.

### Use of Composer package

The integration of a Composer package is intended to facilitate effective autoloading and dependency management. Composer makes it easier to add and update third-party libraries, so the plugin always runs with compatible and up-to-date parts. This approach streamlines upkeep and brings the development into compliance with current PHP standards.

## Testing Details

For testing purposes I decided to go with PHPUnit framework in conjunction with `WP_MOCK` library.
The decision to use `WP_MOCK` is because it facilitates the testing process when native Wordpress API functions are in use.

### Running Unit Tests

To run the tests, navigate to the root directory of the plugin and execute the following command in your terminal:

```./vendor/bin/phpunit --bootstrap tests/PHPUnit/bootstrap.php```