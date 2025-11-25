<?php 
    /** 
     * Affichage des articles : liste des articles avec vue des vues, commentaires et date de publication. 
     */
    require_once('models/DBManager.php');
    include 'icons/arrow-down.svg';
    include 'icons/arrow-up.svg';

    if (isset($_GET['orderDir'])) {

    }

    $pdo = DBManager::getInstance()->getPDO();

    $query = 
            'select a.title, a.views, a.date_creation, count(c.id) as num_of_comments from article a 
            left join comment c on a.id = c.id_article
            group BY a.id ';

    $orderByParam = '';

    //todo add enum here ?

    if (isset($_GET['filterVar']) && isset($_GET['orderDir'])) {
        if ($_GET['orderDir'] === 'ASC' || $_GET['orderDir'] === 'DESC') {
            if (in_array($_GET['filterVar'], ['title', 'date_creation', 'views'])) {
                $orderByParam = 'order by a.' . $_GET['filterVar'];
            } else if ($_GET['filterVar'] = 'num_of_comments') {
                $orderByParam = 'order by num_of_comments';
            }

            $orderByParam .= ' ' . $_GET['orderDir'];
        }
    }
    
    $query .= $orderByParam;

    $statement = $pdo->prepare($query);
    $statement->execute();
    $articles = $statement->fetchAll();

?>

<h2>Monitoring</h2>

<div class="adminArticle">
    <div class="articleLine">
        <div class="content">
            <a href='index.php?action=monitoring&filterVar=title&orderDir=ASC'>
                <svg class="icon" aria-hidden="true">
                    <use href="icons/arrow-up.svg#arrow-up"></use>
                </svg>
            </a>
            <h2>title</h2>
            <a href='index.php?action=monitoring&filterVar=title&orderDir=DESC'>
                <svg class="icon" aria-hidden="true">
                    <use href="icons/arrow-down.svg#arrow-down"></use>
                </svg>
            </a>
        </div>
        <div class="content">
            <a href='index.php?action=monitoring&filterVar=num_of_comments&orderDir=ASC'>
                <svg class="icon" aria-hidden="true">
                    <use href="icons/arrow-up.svg#arrow-up"></use>
                </svg>
            </a>
            <h2>number of comments</h2>
            <a href='index.php?action=monitoring&filterVar=num_of_comments&orderDir=DESC'>
                <svg class="icon" aria-hidden="true">
                    <use href="icons/arrow-down.svg#arrow-down"></use>
                </svg>
            </a>
        </div>
        <div class="content">
            <a href='index.php?action=monitoring&filterVar=creation_date&orderDir=ASC'>
                <svg class="icon" aria-hidden="true">
                    <use href="icons/arrow-up.svg#arrow-up"></use>
                </svg>
            </a>
            <h2>creation date</h2>
            <a href='index.php?action=monitoring&filterVar=creation_date&orderDir=DESC'>
                <svg class="icon" aria-hidden="true">
                    <use href="icons/arrow-down.svg#arrow-down"></use>
                </svg>
            </a>
        </div>
        <div class="content">
            <a href='index.php?action=monitoring&filterVar=views&orderDir=ASC'>
                <svg class="icon" aria-hidden="true">
                    <use href="icons/arrow-up.svg#arrow-up"></use>
                </svg>
            </a>
            <h2>views</h2>
            <a href='index.php?action=monitoring&filterVar=views&orderDir=DESC'>
                <svg class="icon" aria-hidden="true">
                    <use href="icons/arrow-down.svg#arrow-down"></use>
                </svg>
            </a>
        </div>
    </div>
    <?php foreach ($articles as $article) { ?>
        <div class="articleLine">
            <div class="title"><?= $article['title'] ?></div>
            <div class="content"><?= $article['num_of_comments']  ?></div>
            <div class="content"><?= $article['date_creation']?></div>
            <div class="content"><?= $article['views']?></div>
        </div>
    <?php } ?>
</div>