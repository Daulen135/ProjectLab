<?php
use app\modules\sitemap\Module;

echo '<?xml version="1.0" encoding="utf-8"?>' . PHP_EOL;
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
	xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
	
    <?php foreach ($urls as $url): ?>
        <url> <loc><![CDATA[<?= $url['loc'] ?>]]></loc>
            <?php if (isset($url['lastmod'])): ?>
                <lastmod><?=is_string ( $url ['lastmod'] ) ? $url ['lastmod'] : date ( DATE_W3C, $url ['lastmod'] )?></lastmod>
            <?php endif; ?>

                <changefreq><?= isset($url['changefreq']) ? $url['changefreq'] : Module::CHANGEFREQ_DAILY ?></changefreq>

<priority><?= isset($url['priority'])? $url['priority'] : Module::PRIORITY ?></priority>
    
            <?php if (isset($url['news'])): ?>
                <news:news>
	<news:publication>
		<news:name><?= $url['news']['publication']['name'] ?></news:name>
		<news:language><?= $url['news']['publication']['language'] ?></news:language>
	</news:publication>
                    <?php
            echo isset($url['news']['access']) ? "<news:access>{$url['news']['access']}</news:access>" : '';
            echo isset($url['news']['genres']) ? "<news:genres>{$url['news']['genres']}</news:genres>" : '';
            ?>
                    <news:publication_date>
                        <?=is_string ( $url ['news'] ['publication_date'] ) ? $url ['news'] ['publication_date'] : date ( DATE_W3C, $url ['news'] ['publication_date'] )?>
                    </news:publication_date>
	<news:title> <?= $url['news']['title'] ?></news:title>
                    <?php
            echo isset($url['news']['keywords']) ? "<news:keywords>{$url['news']['keywords']}</news:keywords>" : '';
            echo isset($url['news']['stock_tickers']) ? "<news:stock_tickers>{$url['news']['stock_tickers']}</news:stock_tickers>" : '';
            ?>
                </news:news>
            <?php endif; ?>
            <?php

        if (isset($url['images'])) :
            foreach ($url['images'] as $image) :
                ?>
                    <image:image>
	<image:loc><![CDATA[<?= $url['loc'] ?>]]></image:loc>
                        <?php
                echo isset($image['caption']) ? "<image:caption>{$image['caption']}</image:caption>" : '';
                echo isset($image['geo_location']) ? "<image:geo_location>{$image['geo_location']}</image:geo_location>" : '';
                echo isset($image['title']) ? "<image:title>{$image['title']}</image:title>" : '';
                echo isset($image['license']) ? "<image:license>{$image['license']}</image:license>" : '';
                ?>
                    </image:image>
                <?php
            endforeach
            ;
					
            endif;

        ?>
        </url>
    <?php endforeach; ?>
</urlset>
