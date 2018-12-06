<?php
    //........................
    // VARIABLES
    //........................

    // Open the books csv file in read mode.
    $booksCSVFile = fopen("books.csv", "r");

    // Store data from csv file in an array.
    $books = GetBookData($booksCSVFile);

    // Store unique authors names in an array.
    $authors = GetUniqueAuthors($books);

    //........................
    // LOGIC AND UI
    //........................

    // Creates top half of a skeletal HTML page.
    CreateHtmlSkeletonTop("Author Display");
    // Creates the required HTML elements for a search form.
    CreateSearchElements();
    echo "<section>";

    // If GET data is present relating to an author, display the authors books.
    // Otherwise display all authors.
    if(isset($_GET["author"])) {
        DisplayAuthorWorks($books, $_GET["author"]);
    } else {
        DisplayAllAuthors($authors);
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
    ** Loops through book data array, gets each individual author's name and then stores every unique and sorted author's name into a new array of names.
    ** Returns an array of unique author names.
    ** @param $booksArray the array of book data extracted from the csv file.
    */
    function GetUniqueAuthors($booksArray) {
        // Loop through array of book data retrieved from csv file.
        foreach($booksArray as $row) {
            // Seperates each author name from multi author books if present, otherwise stores individual author's name.
            $authorName = explode("&", $row[1]);
            // Loops through each index of the authorName array.
            foreach($authorName as $name) {
                // If the author's name is not blank add the name, trimmed of whitespace, to the authorsNames array.
                if (!empty($name)) {
                    $authorsNames[] = trim($name);
                }
            }
        }
        // Removes duplicate entries from authorsNames array.
        $uniqueAuthors = array_unique($authorsNames);
        // Sorts uniqueAuthors array in alphabetical order, according to surname.
        sort($uniqueAuthors);
        return $uniqueAuthors;
    }

    /*
    ** Displays each unique author's name from the authors array as a link, formatted with data to be parsed on click.
    ** @param $authorsArray the array of unique authors that was extracted from the book csv file and then processed by GetUniqueAuthors().
    */
    function DisplayAllAuthors($authorsArray) {
        // Page heading.
        echo "<h1 id='top'>All Authors</h1>";
        // Creates alphabetical index links for main display page.
        CreateLetterIndex();
        // Loops through the array of authors.
        foreach($authorsArray as $author) {
            // Sets a static letter variable and a variable to hold the first letter or the current authors name.
            static $letter = "";
            $firstLetterOfName = substr($author, 0, 1);
            // Checks if the first letter of the author's name is different than the value in the variable letter.
            // If it is set the static variable letter to the first letter of the author's name and output as a header.
            // This acts as an organiser for author names by visually grouping them by the common alphabetical first letter of their surname.
            if($letter != $firstLetterOfName) {
                $letter = $firstLetterOfName;
                echo "<h2 id='$letter'>$letter</h2>";
                echo "<hr>";
            }
            // Output HTML anchor with authors name.
            echo "<a href='display.php?author=$author' class='authorLink'>$author</a>";
        }
    }

    /*
    ** Displays an individual author's works.
    ** @param $booksArray the array of book data extracted from the csv file.
    ** @param $authorName the name of the author whos titles you want to retrieve.
    */
    function DisplayAuthorWorks($booksArray, $authorName) {
        echo "<h2 id='top'>$authorName</h2>";
        echo "<hr>";
        echo "<h3>Titles</h3>";
        // Sorts the book titles alphabetically.
        sort($booksArray);
        // Loop through array of book data retrieved from csv file.
        foreach($booksArray as $row) {
            // Seperates each author name from multi author books if present, otherwise stores individual author's name.
            $names = explode("&", $row[1]);
            // Loops through each name in the names array.
            foreach($names as $name) {
                // If a name is not empty and also matches the authorName parameter, display their works.
                if(!empty($name) && $name == $authorName) {
                    echo "<p>&bull; $row[0] &bull;</p>";
                }
            }
        }
        // Link to show all authors.
        echo "<hr>";
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
    ** Creates the HTML elements to form an alphabetical index.
    */
    function CreateLetterIndex() {
        echo "<div class='indexContainer'>";
        echo "<a href='#A' class='index'>A</a>";
        echo "<a href='#B' class='index'>B</a>";
        echo "<a href='#C' class='index'>C</a>";
        echo "<a href='#D' class='index'>D</a>";
        echo "<a href='#E' class='index'>E</a>";
        echo "<a href='#F' class='index'>F</a>";
        echo "<a href='#G' class='index'>G</a>";
        echo "<a href='#H' class='index'>H</a>";
        echo "<a href='#I' class='index'>I</a>";
        echo "<a href='#J' class='index'>J</a>";
        echo "<a href='#K' class='index'>K</a>";
        echo "<a href='#L' class='index'>L</a>";
        echo "<a href='#M' class='index'>M</a>";
        echo "<a href='#N' class='index'>N</a>";
        echo "<a href='#O' class='index'>O</a>";
        echo "<a href='#P' class='index'>P</a>";
        echo "<a href='#Q' class='index'>Q</a>";
        echo "<a href='#R' class='index'>R</a>";
        echo "<a href='#S' class='index'>S</a>";
        echo "<a href='#T' class='index'>T</a>";
        echo "<a href='#U' class='index'>U</a>";
        echo "<a href='#V' class='index'>V</a>";
        echo "<a href='#W' class='index'>W</a>";
        echo "<a href='#X' class='index'>X</a>";
        echo "<a href='#Y' class='index'>Y</a>";
        echo "<a href='#Z' class='index'>Z</a>";
        echo "</div>";
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