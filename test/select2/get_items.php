<?php
// Get the search term and page number from the request
$q = isset($_GET['q']) ? $_GET['q'] : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Define the number of items per page
$perPage = 10;

// Perform the search query using the search term and page number
// Here, we're using a simple array of items for demonstration purposes
$items = array(
    array('id' => 1, 'name' => 'Item 1'),
    array('id' => 2, 'name' => 'Item 2'),
    array('id' => 3, 'name' => 'Item 3'),
    array('id' => 4, 'name' => 'Item 4'),
    array('id' => 5, 'name' => 'Item 5'),
    array('id' => 6, 'name' => 'Item 6'),
    array('id' => 7, 'name' => 'Item 7'),
    array('id' => 8, 'name' => 'Item 8'),
    array('id' => 9, 'name' => 'Item 9'),
    array('id' => 10, 'name' => 'Item 10'),
    array('id' => 11, 'name' => 'Item 11'),
    array('id' => 12, 'name' => 'Item 12'),
    array('id' => 13, 'name' => 'Item 13'),
    array('id' => 14, 'name' => 'Item 14'),
    array('id' => 15, 'name' => 'Item 15'),
    array('id' => 16, 'name' => 'Item 16'),
    array('id' => 17, 'name' => 'Item 17'),
    array('id' => 18, 'name' => 'Item 18'),
    array('id' => 19, 'name' => 'Item 19'),
    array('id' => 20, 'name' => 'Item 20')
);

$filteredItems = array_filter($items, function ($item) use ($q) {
    return strpos(strtolower($item['name']), strtolower($q)) !== false;
});

// Calculate the total number of pages
$numPages = ceil(count($filteredItems) / $perPage);

// Paginate the results based on the page number and number of items per page
$slicedItems = array_slice($filteredItems, ($page - 1) * $perPage, $perPage);

// Return the results as a JSON response
echo json_encode(array(
    'items' => $slicedItems,
    'hasMorePages' => $page < $numPages
));
