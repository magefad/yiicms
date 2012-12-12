<?php
/**
 * @author Fadeev Ruslan <fadeevr@gmail.com>
 * Date: 07.12.12
 * Time: 15:49
 * @var $urls array
 */
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\r\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($urls as $url => $data) : ?>
    <url>
        <loc><?php echo $url ?></loc>
<?php if (!empty($data['lastmod'])): ?>
        <lastmod><?php echo $data['lastmod']; ?></lastmod>
<?php endif; ?>
<?php if (!empty($data['changefreq'])): ?>
        <changefreq><?php echo $data['changefreq']; ?></changefreq>
<?php endif; ?>
<?php if (!empty($data['priority'])): ?>
        <priority><?php echo $data['priority']; ?></priority>
<?php endif; ?>
    </url>
<?php endforeach; ?>
</urlset>
