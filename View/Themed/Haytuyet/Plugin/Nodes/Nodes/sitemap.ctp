<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo $this->Html->url ('/', true) ?></loc>
        <lastmod><?php echo date ('c', time()); ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc><?php echo $this->Html->url ('/clip/hot', true) ?></loc>
        <lastmod><?php echo date ('c', time()); ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc><?php echo $this->Html->url ('/clip/hay', true) ?></loc>
        <lastmod><?php echo date ('c', time()); ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc><?php echo $this->Html->url ('/clip/vui', true) ?></loc>
        <lastmod><?php echo date ('c', time()); ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
    <?php
    foreach ($nodes as $node) {
        ?>
        <url>
            <loc><?php echo $this->Html->url ($node['Node']['url'], true); ?></loc>
            <lastmod><?php echo date ('c', time()); ?></lastmod>
            <changefreq>daily</changefreq>
            <priority>0.5</priority>
        </url>
    <?php
    }
    ?>
</urlset>