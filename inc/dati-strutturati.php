<?php

/*

Crea un json di dati strutturati nel head della pagina con le informazioni del tipo di post

*/



// Rimozione dei dati strutturati di YoastSEO:
//add_filter( 'wpseo_json_ld_output', '__return_false' );


class DatiStrutturati {

	private $organization = null;

	private $virgola = '';

	public function __construct(){

		add_action( 'wp_head', array($this,'head'), 1 );

		$blogName = get_bloginfo('name');
		$homeUrl = get_home_url();
		$logo = get_stylesheet_directory_uri().'/assets/images/logo.png';

		$this->organization = (object) array(
			'name' => $blogName,
			'url' => $homeUrl,
			'logo' => (object) array(
				'url' => $logo,
				'width' => 877,
				'height' => 893
			)
		);

	}

	public function head(){
        if (get_post_type( get_the_ID() ) != 'events' ){
		?><script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@graph": [
                <?php

			// $this->filtraDatiOrganization();

			// Dati strutturati di tipo "WEBSITE"
            $this->getDatiStrutturatiWebsite();

			// Dati strutturati di tipo "ORGANIZATION":
            $this->getDatiStrutturatiOrganization();

			// Dati strutturati di tipo "ARTICLE":
            //$this->getDatiStrutturatiArticle();

			// Dati strutturati di "NEWS ARTICLE":
            $this->getDatiStrutturatiNewsArticle();

			// Dati strutturati di tipo "ITEM LIST":
            $this->getDatiStrutturatiItemList();

            // Dati strutturati di tipo "PODCAST":
            //$this->getDatiStrutturatiPodcast();

			// Dati strutturati di tipo "PRODUCT":
			$this->getDatiStrutturatiProduct();

			// Dati strutturati di tipo "EVENT":
            //$this->getDatiStrutturatiEvent();

			?>]
    }
</script>
<?php }


	}

	/**
	 * Funzione per inserire i dati strutturati di tipo Website
	 * @link https://schema.org/WebSite
	 */
	private function getDatiStrutturatiWebsite(){

		// Filtro per disabilitare i dati strutturati "WEBSITE":
		$abilitaDatiStrutturatiWebsite = apply_filters('abilita_dati_strutturati_website', true);

		if(!$abilitaDatiStrutturatiWebsite) {
		    return;
		}

		// Recupero i profili social da YoastSEO:
		$arrProfiliSocial = $this->getProfiliSocial();

		echo $this->virgola;
		?>
        {
        "@type": "WebSite",
        "name": "<?php echo $this->_escapeDoppiApici( $this->organization->name ); ?>",
        "url": "<?php echo $this->organization->url; ?>",
		<?php if($arrProfiliSocial && is_array($arrProfiliSocial)){
			?>"sameAs" : [<?php echo '"' . implode( '","', $arrProfiliSocial ) . '"'; ?>]
		<?php } ?>
        }
		<?php
		$this->virgola = ',';
	}

	/**
	 * Funzione per inserire i dati strutturati di tipo Organization
	 * @link https://schema.org/Organization
	 */
	private function getDatiStrutturatiOrganization(){

	    // Filtro per disabilitare i dati strutturati "Organization":
		$abilitaDatiStrutturatiOrganization = apply_filters('abilita_dati_strutturati_organization', true);

		if(!$abilitaDatiStrutturatiOrganization) {
			return;
		}

		$socialProfiles = $this->getProfiliSocial();

		echo $this->virgola;
		?>
        {
		    "@type": "Organization",
		    "name": "<?php echo $this->_escapeDoppiApici( $this->organization->name ); ?>",
		    "logo": "<?php echo $this->organization->logo->url; ?>",
		    "url": "<?php echo $this->organization->url; ?>",
			<?php if($socialProfiles && is_array($socialProfiles)){ ?>
		    "sameAs" : [ <?php echo '"' . implode( '","', $socialProfiles ) . '"'; ?> ]
			<?php } ?>
		}
	<?php
		$this->virgola = ',';
	}

	/**
	 * Funzione per inserire i dati strutturati di tipo Article
	 * @link https://schema.org/Article
	 */
	private function getDatiStrutturatiArticle(){

		$abilitaDatiStrutturatiArticle = apply_filters('abilita_dati_strutturati_article', true);

		if( !$abilitaDatiStrutturatiArticle ) {
			return;
		}

		// Solo per SINGLE e POST
		if( !is_single() && !is_page() ) {
			return;
		}

		global $wp_query;
		$postId = $wp_query->post->ID;

		// Informazioni base sul post:
		$title = $this->_escapeDoppiApici( get_the_title($postId) );
		$url = get_the_permalink($postId);
		$description = $this->_escapeDoppiApici( $this->getDescription() );
		$datePublished = get_the_date("Y-m-d\TH:i:s\Z", $postId);
		$dateModified = get_the_modified_date("Y-m-d\TH:i:s\Z", $postId);
		$image = wp_get_attachment_image_src( get_post_thumbnail_id($postId), 'full' );

        // Autore del post:
		$authorId = get_post_field( 'post_author', $postId );
		$firstName = get_the_author_meta('first_name', $authorId);
		$lastName = get_the_author_meta('last_name', $authorId);
		$author = $firstName . ' ' . $lastName;
		$author = apply_filters('dati_strutturati_nome_autore', $author);

		if(!$image){
			$image = apply_filters('dati_strutturati_immagine_default', $image);
			if(!$image){
				$image[0] = $this->organization->logo->url;
				$image[1] = $this->organization->logo->width;
				$image[2] = $this->organization->logo->height;
			}
		}

		echo $this->virgola;
		?>
{
  "@type": "Article",
  "name": "<?php echo $title; ?>",
  "headline": "<?php echo $title; ?>",
  "description": "<?php echo $description; ?>",
  "datePublished": "<?php echo $datePublished; ?>",
  <?php if($dateModified != $datePublished){ ?>
  "dateModified": "<?php echo $dateModified; ?>",
  <?php } ?>
  "mainEntityOfPage": {
  		"@type": "WebPage",
  		"@id": "<?php echo $url; ?>"
  },
  "url": "<?php echo $url; ?>",
  "image": {
        	"@type": "ImageObject",
        	"url": "<?php echo $image[0]; ?>",
        	"height": <?php echo $image[2]; ?>,
          	"width": <?php echo $image[1]; ?>
        },
  "author": {
    	"@type": "Person",
    	"name": "<?php echo $author; ?>",
    	"url": "<?php echo $this->organization->url; ?>"
	},
  "publisher": {
		"@type": "Organization",
		"name": "<?php echo $this->organization->name; ?>",
		"logo": {
        	"@type": "ImageObject",
            "url": "<?php echo $this->organization->logo->url; ?>",
            "width": <?php echo $this->organization->logo->width; ?>,
            "height": <?php echo $this->organization->logo->height; ?>
        }
    }
}
		<?php
		$this->virgola = ',';
	}

	/**
	 * Funzione per inserire i dati strutturati di tipo NewsArticle
	 * @link https://schema.org/NewsArticle
	 */
	private function getDatiStrutturatiNewsArticle(){

		$abilitaDatiStrutturatiNewsArticle = apply_filters('abilita_dati_strutturati_news_article', true);

		if( !$abilitaDatiStrutturatiNewsArticle ) {
			return;
		}

		// Solo per SINGLE
		if( !is_single() ) {
			return;
		}

		global $wp_query;
		$postId = $wp_query->post->ID;

		// Informazioni base sul post:
		$title = $this->_escapeDoppiApici( get_the_title($postId) );
		$url = get_the_permalink($postId);
		$description = $this->_escapeDoppiApici( $this->getDescription() );
		$datePublished = get_the_date("Y-m-d\TH:i:s\Z", $postId);
		$dateModified = get_the_modified_date("Y-m-d\TH:i:s\Z", $postId);
		$image = wp_get_attachment_image_src( get_post_thumbnail_id($postId), 'full' );

		// Autore del post:
		$authorId = get_post_field( 'post_author', $postId );
		$firstName = get_the_author_meta('first_name', $authorId);
		$lastName = get_the_author_meta('last_name', $authorId);
		$author = $firstName . ' ' . $lastName;
		$author = apply_filters('dati_strutturati_nome_autore', $author);

		if(!$image){
			$image = apply_filters('dati_strutturati_immagine_default', $image);
			if(!$image){
				$image[0] = $this->organization->logo->url;
				$image[1] = $this->organization->logo->width;
				$image[2] = $this->organization->logo->height;
			}
		}

		echo $this->virgola;
		?>
        {
        "@type": "NewsArticle",
        "url": "<?php echo $url; ?>",
        "publisher": {
            "@type": "Organization",
            "name": "<?php echo $this->organization->name; ?>",
            "logo": {
                "@type": "ImageObject",
                "url": "<?php echo $this->organization->logo->url; ?>",
                "width": <?php echo $this->organization->logo->width; ?>,
                "height": <?php echo $this->organization->logo->height; ?>
            }
        },
        "headline": "<?php echo $title; ?>",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "<?php echo $url; ?>"
        },
        "description": "<?php echo $description; ?>",
        "datePublished": "<?php echo $datePublished; ?>",
		<?php if($dateModified != $datePublished){ ?>
        "dateModified": "<?php echo $dateModified; ?>",
		<?php } ?>
        "image": {
        "@type": "ImageObject",
            "url": "<?php echo $image[0]; ?>",
            "height": <?php echo $image[2]; ?>,
            "width": <?php echo $image[1]; ?>
        },
        "author": {
            "@type": "Person",
            "name": "<?php echo $author; ?>",
            "url": "<?php echo $this->organization->url; ?>"
        }
        }
		<?php
		$this->virgola = ',';
	}

	/**
	 * Funzione per inserire i dati strutturati di tipo ItemList (per gli articoli correlati)
	 * @link https://schema.org/ItemList
	 */
	private function getDatiStrutturatiItemList(){


		$abilitaDatiStrutturatiItemList = apply_filters('abilita_dati_strutturati_item_list', true);

		if( !$abilitaDatiStrutturatiItemList ) {
			return;
		}

		// Solo per SINGLE e CATEGORY
		if( !is_single() && !is_category() ){
            return;
        }

		global $wp_query;
		$postId = $wp_query->post->ID;

		// Recupero le categorie del post:
		$arrCategories = get_the_category($postId);

		if (!$arrCategories || empty($arrCategories)) {
            return;
        }

	    $postPerPage = apply_filters('dati_strutturati__item_list_posts_per_page', 5);

        // Preparo gli argomenti per la query per il recupero dei correlati:
        $args = array(
	        'posts_per_page'      => $postPerPage,
	        'category'         => $arrCategories[0]->term_id, // Recupero l'id della prima categoria del post
	        'orderby'          => 'date',
	        'order'            => 'DESC',
        );

		// Se mi trovo sulla single, escludo dagli ItemList la url della pagina medesimaz:
		if(is_single()){
			$args['exclude'] = array($postId);
		}

		// Recupero i correlati:
		$arrCorrelati = get_posts($args);

		if(!count($arrCorrelati)){
			return;
		}

		echo $this->virgola;


		$nomeItemList = apply_filters('nome_item_list', 'Articoli correlati');
		$descrizioneItemList = apply_filters('descrizione_item_list', 'Forse potrebbero interessarti anche questi altri articoli');

		?>
        {
        "@type": "ItemList",
        "name": "<?php echo $nomeItemList; ?>",
        "description": "<?php echo $descrizioneItemList; ?>",
        "itemListElement": [

        <?php

		$virgolaCorrelati = '';
		foreach($arrCorrelati as $key => $correlato) {

			$urlCorrelato = '';
		    echo $virgolaCorrelati;
			?>
            {
            "@type":"ListItem",
            "position": <?php echo ($key+1); ?>,
            "url":"<?php the_permalink($correlato); ?>"
            }
			<?php
			$virgolaCorrelati = ',';
		}

		?>
        ]
        }
		<?php

        wp_reset_query();

		$this->virgola = ',';
	}


    /**
	 * Funzione per inserire i dati strutturati di tipo PodcastEpisode
	 * @link https://schema.org/PodcastEpisode
	 */
	private function getDatiStrutturatiPodcast(){

            $abilitaDatiStrutturatiPodcast = apply_filters('abilita_dati_strutturati_podcast', true);

            if( !$abilitaDatiStrutturatiPodcast ) {
                return;
            }

            // Solo per SINGLE e POST
            if( !is_single() && !is_page() ) {
                return;
            }

            global $wp_query;
            $postId = $wp_query->post->ID;

            // Informazioni base sul post:
            $title = $this->_escapeDoppiApici( get_the_title($postId) );
            $url = get_the_permalink($postId);
            $description = $this->_escapeDoppiApici( $this->getDescription() );
            $datePublished = get_the_date("Y-m-d\TH:i:s\Z", $postId);
            $dateModified = get_the_modified_date("Y-m-d\TH:i:s\Z", $postId);
            $image = wp_get_attachment_image_src( get_post_thumbnail_id($postId), 'full' );
            $categories = get_the_category($postId);
            $categorie_name = $categories[0]->name;
            $categorie_url = esc_url( get_category_link( $categories[0]->term_id ) );

            // file audio 
            $audioID = get_post_meta($postId, 'Spreaker_file_id', true);
            $file_url = 'https://widget.spreaker.com/player?episode_id='.$audioID;

            // Autore del post:
            $authorId = get_post_field( 'post_author', $postId );
            $firstName = get_the_author_meta('first_name', $authorId);
            $lastName = get_the_author_meta('last_name', $authorId);
            $author = $firstName . ' ' . $lastName;
            $author = apply_filters('dati_strutturati_nome_autore', $author);

            if(!$image){
                $image = apply_filters('dati_strutturati_immagine_default', $image);
                if(!$image){
                    $image[0] = $this->organization->logo->url;
                    $image[1] = $this->organization->logo->width;
                    $image[2] = $this->organization->logo->height;
                }
            }

            echo $this->virgola;
            ?>
            {
                "@context": "http://schema.org/",
                "@type": "PodcastEpisode",
                "url":"<?php echo $url; ?>",
                "name":  "<?php echo $title; ?>",
                "datePublished": "<?php echo $datePublished; ?>",
                "description": "<?php echo $description; ?>",
                "associatedMedia": {
                    "@type": "MediaObject",
                    "embedUrl": "<?php echo $file_url; ?>"
                },
                "partOfSeries": {
                    "@type": "PodcastSeries",
                    "name": "<?php echo $categorie_name; ?>",
                    "url": "<?php echo $categorie_url; ?>"
                }
            }
            <?php
            $this->virgola = ',';
		}
		
		  /**
	 * Funzione per inserire i dati strutturati di tipo Product
	 * @link https://schema.org/Product
	 */
	private function getDatiStrutturatiProduct(){

		$abilitaDatiStrutturatiProduct = apply_filters('abilita_dati_strutturati_product', true);

		if( !$abilitaDatiStrutturatiProduct ) {
			return;
		}

		// Solo per PRODUCT Woocommerce
		if ( !class_exists( 'WooCommerce' ) ) {
			return;
		}
		if( !is_product() ) {
			return;
		}

		global $wp_query;
		$postId = $wp_query->post->ID;

		// Informazioni base sul post:
		$title = $this->_escapeDoppiApici( get_the_title($postId) );
		$url = get_the_permalink($postId);
		$description = $this->_escapeDoppiApici( $this->getDescription() );
		$datePublished = get_the_date("Y-m-d\TH:i:s\Z", $postId);
		$dateModified = get_the_modified_date("Y-m-d\TH:i:s\Z", $postId);
		$image = wp_get_attachment_image_src( get_post_thumbnail_id($postId), 'full' );
		$categories = get_the_category($postId);
		$categorie_name = $categories[0]->name;
		$categorie_url = esc_url( get_category_link( $categories[0]->term_id ) );

		// Prodotto woocommerce
		if ( class_exists( 'WooCommerce' ) ) {
			// code that requires WooCommerce
			$product = wc_get_product( $postId );
			$prezzo_regolare = $product->get_regular_price();
			$prezzo_scontato = $product->get_sale_price();
			$prezzo = $product->get_price();
			// questo richiede wc marketplace
			if (class_exists('WCMp')){
				$brand = get_wcmp_product_vendors( $postId );
			}else{
				$brand = null;
			}
			

			$currency = get_woocommerce_currency();

			$rating_count = $product->get_rating_count();
			$average = $product->get_average_rating();
		  }else{
			$product = null;
			$prezzo_regolare = null;
			$prezzo_scontato = null;
			$prezzo = null;
			$brand = null;
	
			$currency = null;
	
			$rating_count = null;
			$average = null;
		  }
		
		
		foreach( get_approved_comments( $postId ) as $review ) {
			if( $review->comment_type === 'review' ) {
				$products_reviews[] = (object) [
					'author'    => $review->comment_author,
					'email'     => $review->comment_author_email,
					'date'      => strtotime($review->comment_date),
					'content'   => $review->comment_content,
				];
			}
		}

		// Autore del post:
		$authorId = get_post_field( 'post_author', $postId );
		$firstName = get_the_author_meta('first_name', $authorId);
		$lastName = get_the_author_meta('last_name', $authorId);
		$author = $firstName . ' ' . $lastName;
		$author = apply_filters('dati_strutturati_nome_autore', $author);

		if(!$image){
			$image = apply_filters('dati_strutturati_immagine_default', $image);
			if(!$image){
				$image[0] = $this->organization->logo->url;
				$image[1] = $this->organization->logo->width;
				$image[2] = $this->organization->logo->height;
			}
		}

		echo $this->virgola;
		?>
		{
			"@context": "http://schema.org",
			"@type": "Product",
			"aggregateRating": {
				"@type": "AggregateRating",
				"ratingValue": "<?php echo $average; ?>",
				"reviewCount": "<?php echo $rating_count; ?>"
			},
			"description": "<?php echo $description; ?>",
			"name": "<?php echo $title; ?>",
			"image": "<?php echo $image; ?>",
			"category":"<?php echo $categorie_name; ?>",
			"brand": "<?php echo $brand; ?>",
			"offers": {
				"@type": "Offer",
				"availability": "http://schema.org/InStock",
				"price": "<?php echo $prezzo; ?>",
				"priceCurrency": "<?php echo $currency; ?>"
			},
			"review": [
			<?php 
				if ($products_reviews != null){
					foreach ($products_reviews as $revew) { ?>
					{
					"@type": "Review",
					"author": "<?php echo $revew['author']; ?>",
					"datePublished": "<?php echo $revew['date']; ?>",
					"description": "<?php echo $revew['content']; ?>",
					"name": "<?php echo $revew['content']; ?>",
					"reviewRating": {
						"@type": "Rating",
						"bestRating": "5",
						"ratingValue": "<?php echo $average; ?>",
						"worstRating": "<?php echo $rating_count; ?>"
					}
					},
			<?php }
		        } ?>
			]
		}
		<?php
		$this->virgola = ',';
	}

	  /**
	 * Funzione per inserire i dati strutturati di tipo Event
	 * @link https://schema.org/Event
	 */
	private function getDatiStrutturatiEvent(){

        $abilitaDatiStrutturatiEvent = apply_filters('abilita_dati_strutturati_event', true);

        if( !$abilitaDatiStrutturatiEvent ) {
            return;
        }

        // Solo per Events post 
        if( get_post_type( get_the_ID() ) != 'events' ) {
            return;
        }

        global $wp_query;
        $postId = $wp_query->post->ID;

        // Informazioni base sul post:
        $title = $this->_escapeDoppiApici( get_the_title($postId) );
        $url = get_the_permalink($postId);
        $description = $this->_escapeDoppiApici( $this->getDescription() );
        $datePublished = get_the_date("Y-m-d\TH:i:s\Z", $postId);
        $dateModified = get_the_modified_date("Y-m-d\TH:i:s\Z", $postId);
        $image = wp_get_attachment_image_src( get_post_thumbnail_id($postId), 'full' );
        $categories = get_the_category($postId);
        $categorie_name = $categories[0]->name;
        $categorie_url = esc_url( get_category_link( $categories[0]->term_id ) );

        // evento
        $luogo_evento = get_post_meta( $postId, 'luogo_evento', true );
       
        $data = get_post_meta( $postId, 'data_evento', true );
        $data_evento = date("Y-m-d\TH:i:s\Z", $data );

        // Autore del post:
        $authorId = get_post_field( 'post_author', $postId );
        $firstName = get_the_author_meta('first_name', $authorId);
        $lastName = get_the_author_meta('last_name', $authorId);
        $author = $firstName . ' ' . $lastName;
        $author = apply_filters('dati_strutturati_nome_autore', $author);

        if(!$image){
            $image = apply_filters('dati_strutturati_immagine_default', $image);
            if(!$image){
                $image[0] = $this->organization->logo->url;
                $image[1] = $this->organization->logo->width;
                $image[2] = $this->organization->logo->height;
            }
        }

        echo $this->virgola;
        ?>
       {
        "@context": "http://schema.org",
        "@type": "Event",
        "location": {
            "@type": "Place",
            "address": {
            "@type": "PostalAddress",
            "addressLocality": "<?php echo $luogo_evento; ?>"
            },
            "name": "<?php echo $luogo_evento; ?>"
        },
        "name": "<?php echo $title; ?>",
        "performer": "<?php echo get_bloginfo( 'name' ); ?>",
        "description": "<?php echo $description; ?>",
        "image":  "<?php echo $image[0]; ?>",
        "startDate": "<?php echo $data_evento; ?>",
        "endDate": "<?php echo $data_evento; ?>",
        "offers": {
                "@type": "Offer",
                "price": "0",
                "priceCurrency": "EUR",
                "url": "<?php echo $url; ?>",
                "availability": "true",
                "validFrom": "<?php echo $data_evento; ?>"
            }
        }
        <?php
        $this->virgola = ',';
    }

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

	/**
	 * ########  #######   #######  ##        ######
	 *    ##    ##     ## ##     ## ##       ##    ##
	 *    ##    ##     ## ##     ## ##       ##
	 *    ##    ##     ## ##     ## ##        ######
	 *    ##    ##     ## ##     ## ##             ##
	 *    ##    ##     ## ##     ## ##       ##    ##
	 *    ##     #######   #######  ########  ######
	 */

	// Metodi privati, utilizzati come tools all'interno di questa classe:

	/**
	 * Funzione per effettuare l'escape dei doppi apici nelle stringhe da inserire nei dati strutturati
	 * @param $text
	 *
	 * @return string
	 */
	private function _escapeDoppiApici($text){
		return str_replace('"','\"',$text);
	}

	/**
	 * Funzione per effettuare il resize del logo.
	 * Il logo deve essere largo 600px ed alto 60px
	 *
	 * Se le dimensioni sono diverse, bisogna comunque mantenere questa proporzione
	 * @param $w
	 * @param $h
	 *
	 * @return object
	 */
	private function _ridimensionaLogo($w, $h){

		$maxW = apply_filters('dati_strutturati_maxWlogo', 600);
		$maxH = apply_filters('dati_strutturati_maxHlogo', 60);

		// check for width
		if($w > $maxW){
			$h = round( ($maxW * $h) / $w );
			$w = $maxW;
		}
		// check for height
		if($h > $maxH){
			$w = round( ($maxH * $w) / $h );
			$h = $maxH;
		}
		return (object) array(
			'w' => $w,
			'h' => $h
		);
	}

	private function filtraDatiOrganization(){
		// only useful to edit logo or url data from outside the plugin
		$this->organization = apply_filters('dati_strutturati_organization', $this->organization);

		$resizedImg = $this->_ridimensionaLogo($this->organization->logo->width, $this->organization->logo->height);

		$this->organization->logo->width = $resizedImg->w;
		$this->organization->logo->height = $resizedImg->h;
	}

	/**
	 * Recupero l'excerpt dell'articolo (se possibile, dal meta "description" di YoastSEO:
	 *
	 * @return string
	 */
	private function getDescription(){
		global $post;

		// Provo a recuperare l'excerpt dal meta "description" di YoastSEO:
		$excerpt = get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true);

		// Se non c'è, provo a vedere se il post ha un excerpt; altrimenti, eseguo il cut del post_content):
		if(!$excerpt){
			if(has_excerpt())
				$excerpt = $post->post_excerpt;
			else{
				$excerpt = substr( $post->post_content, 0, 252 ).'...';
			}
		}

		return strip_tags( $excerpt );
	}

	/**
	 * Recupero i link dei profili social da YoastSEO (se presente)
	 *
	 * @return array
	 */
	private function getProfiliSocial(){

		$arrProfiliSocial = get_option('wpseo_social');

		$socialProfiles = array();

		if($arrProfiliSocial){

			if( $arrProfiliSocial['facebook_site'] )
				$socialProfiles[] = $arrProfiliSocial['facebook_site'];

			if( $arrProfiliSocial['twitter_site'] )
				$socialProfiles[] = 'https://twitter.com/'.$arrProfiliSocial['twitter_site'];

			if( $arrProfiliSocial['instagram_url'] )
				$socialProfiles[] = $arrProfiliSocial['instagram_url'];

			if( $arrProfiliSocial['linkedin_url'] )
				$socialProfiles[] = $arrProfiliSocial['linkedin_url'];

			if( $arrProfiliSocial['pinterest_url'] )
				$socialProfiles[] = $arrProfiliSocial['pinterest_url'];

			if( $arrProfiliSocial['youtube_url'] )
				$socialProfiles[] = $arrProfiliSocial['youtube_url'];
		}

		return apply_filters('dati_strutturati_social', $socialProfiles);

	}

}

new DatiStrutturati();