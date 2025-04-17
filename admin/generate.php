<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Posts</title>
    <?php wp_head(); wp_footer(); ?>
</head>
<body>

    
<br>
<br>

<div class="row">
    <div class="col-2"></div>
    <div class="col-8">
    
    <!-- form -->
    <form>
        <div class="mb-3">
            <label for="num_of_post" class="form-label">No. of Fake Posts Will Be Generated ?</label>
            <input type="number" class="form-control" id="num_of_post">
        </div>
        <div class="mb-3">
            <label for="taxonomy_select" class="form-label">Set post's category</label>
            <select class="form-select" id="taxonomy_select" aria-label="Set post's category">
                <option value="0" selected>None</option>
                <option value="1">One</option>
            </select>
        </div>
        <br>
        <div class="mb-3 form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
               Featured Image ?
            </label>
        </div>
        <br>
        <div class="mb-3">
            <label for="post_author" class="form-label">Posts Author</label>
            <select class="form-select" id="post_author" aria-label="Set post's author">
                <option value="0" selected>None</option>
                <option value="1">One</option>
            </select>
        </div>
        <br>
        <div class="mb-3">
            <label for="post_author" class="form-label">Posts Status</label>
            <select class="form-select" id="post_author" aria-label="Set post's author">
                <option value="0" selected>None</option>
                <option value="1">One</option>
            </select>
        </div>
        <br>
        <div class="mb-3">
            <label for="post_date" class="form-label">Post Date</label>
            <input type="text" class="form-control" id="post_date" placeholder="Select date">
        </div>
        <br>
        <div class="mb-3 form-check">
            <input class="form-check-input" type="checkbox" value="" id="invoke_comments">
            <label class="form-check-label" for="invoke_comments">
               Invoke Comments ?
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    </div>
    <div class="col-2"></div>
</div>

<script>
    jQuery(document).ready(function($){
    $("#post_date").datepicker({
        dateFormat: 'yy-mm-dd' // You can change the format as needed
    });
});

</script>

</body>
</html>