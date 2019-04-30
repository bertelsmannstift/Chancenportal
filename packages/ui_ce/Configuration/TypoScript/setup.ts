tt_content.uice_addtohomescreen = FLUIDTEMPLATE
tt_content.uice_addtohomescreen {
    layoutRootPaths.0 = EXT:ui_ce/Resources/Private/Layouts/
    layoutRootPaths.10 = {$plugin.tx_uice.view.layoutRootPath}
    partialRootPaths.0 = EXT:ui_ce/Resources/Private/Partials/
    partialRootPaths.10 = {$plugin.tx_uice.view.partialRootPath}
    templateRootPaths.0 = EXT:ui_ce/Resources/Private/Templates/Content/
    templateRootPaths.10 = {$plugin.tx_uice.view.templateRootPath}
    templateName = Addtohomescreen
}
tt_content.uice_kachel_teaser = FLUIDTEMPLATE
tt_content.uice_kachel_teaser {
    layoutRootPaths.0 = EXT:ui_ce/Resources/Private/Layouts/
    layoutRootPaths.10 = {$plugin.tx_uice.view.layoutRootPath}
    partialRootPaths.0 = EXT:ui_ce/Resources/Private/Partials/
    partialRootPaths.10 = {$plugin.tx_uice.view.partialRootPath}
    templateRootPaths.0 = EXT:ui_ce/Resources/Private/Templates/Content/
    templateRootPaths.10 = {$plugin.tx_uice.view.templateRootPath}
    templateName = KachelTeaser
    dataProcessing.10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
    dataProcessing.10 {
        if.isTrue.field = tx_uice_kachel_teaser_img
        references {
            fieldName = tx_uice_kachel_teaser_img
            table = tt_content
        }
        as = data_tx_uice_kachel_teaser_img
    }
}
tt_content.uice_text_btn = FLUIDTEMPLATE
tt_content.uice_text_btn {
    layoutRootPaths.0 = EXT:ui_ce/Resources/Private/Layouts/
    layoutRootPaths.10 = {$plugin.tx_uice.view.layoutRootPath}
    partialRootPaths.0 = EXT:ui_ce/Resources/Private/Partials/
    partialRootPaths.10 = {$plugin.tx_uice.view.partialRootPath}
    templateRootPaths.0 = EXT:ui_ce/Resources/Private/Templates/Content/
    templateRootPaths.10 = {$plugin.tx_uice.view.templateRootPath}
    templateName = TextBtn
}
tt_content.uice_text_image = FLUIDTEMPLATE
tt_content.uice_text_image {
    layoutRootPaths.0 = EXT:ui_ce/Resources/Private/Layouts/
    layoutRootPaths.10 = {$plugin.tx_uice.view.layoutRootPath}
    partialRootPaths.0 = EXT:ui_ce/Resources/Private/Partials/
    partialRootPaths.10 = {$plugin.tx_uice.view.partialRootPath}
    templateRootPaths.0 = EXT:ui_ce/Resources/Private/Templates/Content/
    templateRootPaths.10 = {$plugin.tx_uice.view.templateRootPath}
    templateName = TextImage
    dataProcessing.10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
    dataProcessing.10 {
        if.isTrue.field = tx_uice_text_image_image
        references {
            fieldName = tx_uice_text_image_image
            table = tt_content
        }
        as = data_tx_uice_text_image_image
    }
}
