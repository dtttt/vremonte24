<?if (!function_exists('hideBreadcrumbsFooter')):?>
    <?function hideBreadcrumbsFooter() { ?>
        <?if (strcasecmp(trim($GLOBALS['APPLICATION']->GetProperty('HIDE_BREADCRUMBS')), 'Y') !== 0): ?>
            <?ob_start();?>

            <?$content = ob_get_contents();
            ob_end_clean();
            return $content;
            ?>
        <?endif?>
    <? } ?>
<?endif?>
<?$_REQUEST['AJAX_CALL'] ? print( hideBreadcrumbsFooter() ) : $APPLICATION->AddBufferContent( hideBreadcrumbsFooter() ); ?>


<?if (!function_exists('hideBreadcrumbsHeader')) { function hideBreadcrumbsHeader() { ?>
    <?if (strcasecmp(trim($GLOBALS['APPLICATION']->GetProperty('HIDE_BREADCRUMBS')), 'Y') !== 0): ?>
        <?ob_start();?>

        <?$content = ob_get_flush();
        ob_end_clean();
        return $content;?>
    <?endif?>
<? } } ?>
<?$_REQUEST['AJAX_CALL'] ? print( hideBreadcrumbsHeader() ) : $APPLICATION->AddBufferContent( hideBreadcrumbsHeader() ); ?>
