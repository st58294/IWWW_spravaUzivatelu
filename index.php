<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="theme.css">
    <meta name="viewport"
          content="width=device-width,
          initial-scale=1.0">

</head>
<body>
<?php
include "menu.php"
?>

<section id="hero">
    <div class="pageHeading">
        <h1>Stock photo</h1>
    </div>
</section>
<section>
    <div id="galleryRow">
        <article class="galleryPreview">
            <a href="fullsize.php">
                <img src="img/NightCity_1.jpg"
                     alt="Car in the night">
            </a>
        </article>

        <article class="galleryPreview">
            <a href="fullsize.php">
                <img src="img/NightCity_2.jpg"
                     alt="Night city">
            </a>
        </article>

        <article class="galleryPreview">
            <a href="fullsize.php">
                <img src="img/NightCity_3.jpg"
                     alt="Night street">
            </a>
        </article>

        <article class="galleryPreview">
            <a href="fullsize.php">
                <img src="img/NightCity_4.jpg"
                     alt="Night street">
            </a>
        </article>

        <article class="galleryPreview">
            <a href="fullsize.php">
                <img src="img/NightCity_5.jpg"
                     alt="Night street">
            </a>
        </article>
        <article class="galleryPreview">
            <a href="fullsize.php">
                <img src="img/NightCity_6.jpg"
                     alt="Night street">
            </a>
        </article>

        </a>
    </div>
</section>

<?php
include "footer.php";

?>

</body>
</html>