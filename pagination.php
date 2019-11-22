<?php

/*************************************************************/
/******************      pagination    **********************/
/*************************************************************/


function pagination($query,$page) {

    $baseURL="http://".$_SERVER['HTTP_HOST'];
    if($_SERVER['REQUEST_URI'] != "/"){
        $baseURL = $baseURL.$_SERVER['REQUEST_URI'];
    }

    // Suppression de '/page' de l'URL
    $sep = strrpos($baseURL, '/page/');
    if($sep != FALSE){
        $baseURL = substr($baseURL, 0, $sep);
    }

  // Suppression des param�tres de l'URL
    $sep = strrpos($baseURL, '?');
    if($sep != FALSE){
    // On supprime le caract�re avant qui est un '/'
        $baseURL = substr($baseURL, 0, ($sep-1));
    }

    //$page = $query->query_vars["paged"];
    if ( !$page ) $page = 1;
    $qs = $_SERVER["QUERY_STRING"] ? "?".$_SERVER["QUERY_STRING"] : "";

    // N�cessaire uniquement si on a plus de posts que de posts par page admis
    if ( $query->found_posts > $query->query_vars["posts_per_page"] ) {
        echo '<ul class="pagination">';
        // lien pr�c�dent si besoin
        if ( $page > 1 ) {
            echo ' <li class="next_prev prev"><a title="Revenir à la page précédente" href="'.$baseURL.'/page/'.($page-1).'/'.$qs.'"><</a></li>';
        }
        // la boucle pour les pages
        for ( $i=1; $i <= $query->max_num_pages; $i++ ) {
            // ajout de la classe active pour la page en cours de visualisation
            if ( $i == $page ) {
                echo '<li class="active"><a href="#pagination" title="Vous êtes sur la page '.$i.'">'.$i.'</a></li>';
            } else {
                if ( ($i == 1)||($i == $query->max_num_pages) ) {
                  echo '<li><a title="Rejoindre la page '.$i.'" href="'.$baseURL.'/page/'.$i.'/'.$qs.'">'.$i.'</a></li>';
                }elseif ( ($i == ($page+2))||($i == ($page-2)) ) {
                  echo '<li><span>...</span></li>';
                }else{
                  if ( ($i < ($page+2))&($i > ($page-2)) ) {
                    echo '<li><a title="Rejoindre la page '.$i.'" href="'.$baseURL.'/page/'.$i.'/'.$qs.'">'.$i.'</a></li>';
                  }
                }
            }
        }
        // le lien next si besoin
        if ( $page < $query->max_num_pages ) {
            echo '<li class="next_prev next"><a title="Passer à la page suivante" href="'.$baseURL.'/page/'.($page+1).'/'.$qs.'">></a></li>';
        }
        echo '</ul>';
    }
}

//pagination($wp_query);
