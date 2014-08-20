<?php
    if(isset($message)) {
        echo $message;
    }
?>

<h2>Categories</h2>

<?php
    if(count($categories) < 1 ) {
        echo "There are currently no categories to display. Create a category by selecting the button above.";
    } else {
?>

<table class="table table-condensed">

    <th>
        <td>Category Id</td>
        <td>Name</td>
        <td>Description</td>
        <td>Edit Category</td>
        <td>Delete Category</td>
    </th>

    <?php
        foreach($categories as $category) {
            echo '<tr>';
                echo '<td>' . $category['id'] . '<td>';
                echo '<td>' . $category['name'] . '</td>';
                echo '<td>' . $category['description'] . '</td>';
                echo '<td><a href="' . site_url("categories/edit/" . $category["id"]) . '">Edit</a></td>';
                echo '<td><a href="' . site_url("categories/delete/" . $category["id"]) . '">Delete</a></td>';
            echo '</tr>';
        }
    ?>
</table>

<?php } ?>
