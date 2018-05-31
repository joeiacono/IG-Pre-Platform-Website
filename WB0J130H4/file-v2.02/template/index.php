<?php
date_default_timezone_set('Europe/London');


define('ROOT', realpath($_SERVER["DOCUMENT_ROOT"]));
$loggedin = FALSE;
$hasPage = FALSE;
$seoPageMeta = [];
$seoPageIndex = NULL;
$seoMeta = [];
if (isset($_GET['page'])) {
    $hasPage = TRUE;
    $pagetitle = $seoPageIndex = strtolower(trim($_GET['page']));

    parse_str($_SERVER['QUERY_STRING'], $output);
    $db = Database::getInstance();
    $conn = $db->getConnection();
    $stmt = $conn->prepare(queryStringSearchBuilder(Count($output)));
    $stmt->execute();
    $seoMetaResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($seoMetaResult)) {
        $seoMeta = array_shift($seoMetaResult);
    }
}

if (isset($_SESSION['admin'])) {
    $loggedin = TRUE;
}

$seoPage = new SeoPage($seoPageIndex, $seoMeta);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Intergalactic Gaming Official Website</title>
    <meta property="description" content=""/>

    <meta property="og:title" content="Intergalactic Gaming Official Website"/>
    <meta property="og:description" content=""/>
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="Intergalactic Gaming"/>

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Intergalactic Gaming Official Website">
    <meta name="author" content="Intergalactic Gaming">

    <link rel="icon" type="image/png" href="/favicon.png">
</head>

<body>

<!-- PAGE CONTENT -->
<?php
$postController = new PostController();
if ($hasPage) {
    $page = $seoPageIndex;
    switch ($page) {
        case 'article':
        case 'privacy':
        case 'news':
        case 'application':
        case 'about':
        case 'streams':
        case 'jobs':
        case '404':
        case 'partners':
        case 'rules':
        case 'raiding':
        case 'home':
        case 'roster':
            if (file_exists(ROOT . "/pages/" . $page . ".php")) {
                // Route and file was found on the system
                include_once(ROOT . "/pages/" . $page . ".php");
            } else {
                // Route was found, but no file on the system exists
                include(ROOT . "/pages/404.php");
            }
            break;
        default:
            if ($postController->checkIfPostsHasTitle($page) === true) {
                include_once(ROOT . "/pages/article.php");
                break;
            } else {
                include(ROOT . "/pages/404.php");
                break;
            }
    }
} else {
    // Page variable is not set, throw homepage
    include(ROOT . "/pages/home.php");
}
?>



</body>
</html>
