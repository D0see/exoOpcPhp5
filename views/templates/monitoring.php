<?php 
    /** 
     * Affichage des articles : liste des articles avec vue des vues, commentaires et date de publication. 
     */
    require_once('models/DBManager.php');

    if (isset($_GET['orderBy'])) {

    }

    $pdo = DBManager::getInstance()->getPDO();

    $query = 
            'select *, count(c.id) as num_of_comments from article a 
            left join comment c on a.id = c.id_article
            group by a.id ';

    $orderBy = '';

    //todo add enum here ?

    if (isset($_GET['filter']) && isset($_GET['orderBy'])) {
        if ($_GET['orderBy'] === 'ASC' || $_GET['orderBy'] === 'DESC') {
            if ($_GET['filter'] === 'title') {
                $orderBy = 'order by a.' . $_GET['filter'];
            } else if ($_GET['filter'] === 'num_of_comments') {
                $orderBy = 'order by ' . $_GET['filter'];
            } else if ($_GET['filter'] === 'views') {
                $orderBy = 'order by ' . $_GET['filter'];
            }
            $orderBy .= ' ' . $_GET['orderBy'];
        }
    }

    $query .= $orderBy;

    $statement = $pdo->prepare($query);
    $statement->execute();
    $articles = $statement->fetchAll();
?>

<h2>Edition des articles</h2>

<div class="adminArticle">
    <div class="articleLine">
        <div class="title">
            <a href='index.php?action=monitoring&filter=title&orderBy=ASC'>^</a>
            <a href='index.php?action=monitoring&filter=title&orderBy=DESC'>v</a>
        </div>
        <div class="content">
            <a href='index.php?action=monitoring&filter=num_of_comments&orderBy=ASC'>^</a>
            <a href='index.php?action=monitoring&filter=num_of_comments&orderBy=DESC'>v</a>
        </div>
        <div class="content">
            <a href='index.php?action=monitoring&filter=date_creation&orderBy=ASC'>^</a>
            <a href='index.php?action=monitoring&filter=date_creation&orderBy=DESC'>v</a>
        </div>
    </div>
    <?php foreach ($articles as $article) { ?>
        <div class="articleLine">
            <div class="title"><?= $article['title'] ?></div>
            <div class="content"><?= $article['num_of_comments']  ?></div>
            <div class="content"><?= $article['date_creation']?></div>
        </div>
    <?php } ?>
</div>

<a class="submit" href="index.php?action=showUpdateArticleForm">Ajouter un article</a>