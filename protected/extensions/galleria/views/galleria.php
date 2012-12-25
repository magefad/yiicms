<?php
/**
 * @var CDataProvider $data
 * @var string $imagePrefixSeparator
 * @var string $srcPrefix
 * @var string $srcPrefixThumb
 */
echo "<div id='galleria_" . $this->id . "' >";
if (isset($bind)) {
    $images = $data->getData();
    foreach ($images as $image) {
        $htmlOptions = array();
        $alt                  = isset($image->$bind['description']) ? $image->$bind['description'] : '';
        $htmlOptions['title'] = isset($image->$bind['title']) ? $image->$bind['title'] : '';

        $imageName     = isset($image->$bind['imagePrefix']) ? $image->$bind['imagePrefix'] . $imagePrefixSeparator . $image->$bind['image'] : $image->$bind['image'];
        $imageSrc      = $srcPrefix . $imageName;
        $imageSrcThumb = $srcPrefixThumb ? $srcPrefixThumb . $imageName : $imageSrc;

        echo CHtml::link(CHtml::image($imageSrcThumb, $alt, $htmlOptions), $imageSrc, $htmlOptions);
    }
}
echo "</div>";
