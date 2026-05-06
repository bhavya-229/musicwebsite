<?php
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'):
    ?>
<div class="card mb-4 mt-5" style="align-self: center;width: 600px;">
    <div class="card-header">
        <h3 class="card-title">Upload Music</h3>
    </div>
    <div class="card-body">
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="title">Author:</label>
                <input type="text" name="author" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="file">Choose Music File:</label>
                <input type="file" name="file" class="form-control-file" accept="audio/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
</div>
<?php
endif;
?>

