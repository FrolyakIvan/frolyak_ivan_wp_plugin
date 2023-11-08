# Frolyak Ivan WP Plugin

**Frolyak Ivan WP Plugin** plugin is a WordPress plugin that shows users data when a custom endpoint is visited. When visiting a custom endpoint, the plugin makes a request to an external API to obtain users data, then selects a template to display this information on the frontend. Users can interact with the data by clicking on one of the three mandatory columns (id, name or username). This will trigger an AJAX request to fetch and display additional user data and display it in the frontend template as well. All the HTTP requests are performed in the server-side.

## Requirements

- WordPress version 6.4 or higher
- PHP version 8.1 or higher

## Installation

1. Clone this repository into your WordPress `wp-content/plugins` directory.
2. Run `composer install` within the cloned directory to install necessary dependencies.

## Usage

Simply activate the plugin in your WordPress dashboard. Then, navigate to the specified custom endpoint to view the plugin in action.

### Custom endpoint
The custom endpoint defined for this task is `/custom-endpoint`

## Implementation Details

The implementation follows the object-oriented programming paradigm. Where each object corresponds to a class that performs certain functions and communicates with other classes.
There is a main class of the plugin that launches all other objects necessary for the operation of this plugin. In addition, there is a class that intercommunicates different components or classes so that the flow can be managed in a centralized way.

The implementation primarily consists of four components:

- **FrolyakIvanWpPlugin Class**: The main class of the plugin, responsible for initializing key components and managing the activation and deactivation of the plugin.
- **EndpointController Class**: Serves as the central class that manages and communicates with other classes or objects. It is responsible for loading styles and scripts, adding rewrite rules, handling AJAX calls, etc.
- **APIService Class**: Handles the execution of HTTP requests and parsing the obtained results.
- **CacheHandler Class**: Responsible for managing the caching of HTTP requests.
- **ViewController Class**: Designed with a "Skeleton" approach, this class is responsible for returning the correct template to the defined endpoint and also save the obtained data from the request.
