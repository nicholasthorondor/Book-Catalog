<?php
    // Imports function file. 
    //require_once("functions.php");

    //........................
    // VARIABLES
    //........................

    // Open the books csv file in read mode.
    $booksCSVFile = fopen("books.csv", "r");

    // Store data from csv file in an array.
    $books = GetBookData($booksCSVFile);

    //........................
    // LOGIC AND UI
    //........................

    // Creates top half of a skeletal HTML page.
    CreateHtmlSkeletonTop("Author and Title Search");
    // Creates the required HTML elements for a search form.
    CreateSearchElements();
    echo "<section>";
    
    // Checks if form has submit data in POST.
    if(isset($_POST["submit"])) {
        // Checks to make sure search entry is not blank.
        if(!empty($_POST["search"])) {
            // Store serach field data in a variable.
            $search = $_POST["search"];
            // Display search results accroding to search field input.
            DisplaySearchResults($books, $search);
        }
    }

    // Closes the books csv file.
    fclose($booksCSVFile);

    // Creates a back to top button.
    CreateBackToTop();
    echo "</section>";
    // Creates bottom half of a skeletal HTML page.
    CreateHtmlSkeletonBottom();

    //.........................
    // FUNCTIONS
    //.........................

    /* Reads each line from the books csv file into a multidimensional array.
    ** Each index of the array represents a line in the csv file.
    ** Inside each index is another array containing the title of the book and the author's name.
    ** Returns a multidimensional array of book data.
    ** @param $file the book.csv file to extract data from.
    */
    function GetBookData($file) {
        // Loop through each line of the csv book file.
        while (!feof($file)) {
            // Stores each line as an array entry into a parent array, creating a ultidimensional array.
            $bookData[] = (fgetcsv($file));
        }
        return $bookData;
    }

    /*
    ** Displays authors and/or titles that match the search string passed in as a parameter.
    ** @param $booksArray the array of book data extracted from the csv file.
    ** @param $search the term/string being searched for.
    */
    function DisplaySearchResults($booksArray, $search) {
        echo "<h2 id='top'>Search results for... <em>$search</em></h2>";
        echo "<hr>";
        // Used to keep track of if a search match has been found.
        $matchFound = false;
        // Loop through array of book data retrieved from csv file.
        foreach($booksArray as $row) {
            // Store the title and author/s of each row in variables.
            $title = $row[0];
            $author = $row[1];
            // Create a regular expression containing the search string entered.
            // \b indicates only the distinct search term is matched. The i indicates case insensitivity.
            $regex = "/\b$search\b/i";
            // Regular expressions signifying non-alphanumeric characters and forward slashes.
            // These are required to prevent potential errors.
            $regex2 = "/^[\W]$/";
            $regex3 = "/\//";
            // Check if the search term contains non-alphanumeric charcters or forward slashes.
            if(!preg_match($regex2, $search) && !preg_match($regex3, $search)) {
                // If the regular expression search term matches the title or the author of a row, display the details.
                if((preg_match($regex, $title) || preg_match($regex, $author))) {
                    echo "<a href='display.php?author=$author' class='authorLink'>$author</a>";
                    echo "<p class='searchTitle'>&bull; $title &bull;</p>";
                    echo "<hr>";
                    $matchFound = true;
                }
            }
        }

        // If no match was found display a message.
        if(!$matchFound) {
            echo "<p>No match found.</p>";
        }

        // Link to show all authors.
        echo "<a href='display.php' class='authorLink showAll'>Show all authors</a>";
    }

    //....................
    // HTML CREATION FUNCTIONS
    //....................

    /*
    ** Creates the required HTML elements for a search form.
    */
    function CreateSearchElements() {
        echo "<header>";
        echo "<form method='POST' action='search.php'>";
        echo "Author and Title search: <input type='search' name='search' required></input>";
        echo "<input type='submit' name='submit' value='Search' class='btn'></input>";
        echo "</form>";
        echo "</header>";
    }

    /*
    ** Creates a back to top button.
    */
    function CreateBackToTop() {
        echo "<a href='#top' class='arrow'>&uarr;</a>";
    }

    /*
    ** Creates the top portion of a skeletal HTML page.
    */
    function CreateHtmlSkeletonTop($title) {
        echo "<!DOCTYPE html>";
        echo "<html>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>$title</title>";
        echo "<link rel='stylesheet' type='text/css' href='style.css'>";
        echo "<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>";
        echo "</head>";
        echo "<body>";
    }

    /*
    ** Creates the bottom portion of a skeletal HTML page.
    */
    function CreateHtmlSkeletonBottom() {
        echo "</body>";
        echo "</html>";
    }
?>