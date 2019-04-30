mod.wizards.newContentElement.wizardItems.common {
    elements {
            addtohomescreen {
                iconIdentifier = tx_uice_addtohomescreen
                title = LLL:EXT:ui_ce/Resources/Private/Language/locallang_db_new_content_el.xlf:wizards.newContentElement.addtohomescreen_title
                description = LLL:EXT:ui_ce/Resources/Private/Language/locallang_db_new_content_el.xlf:wizards.newContentElement.addtohomescreen_description
                tt_content_defValues {
                    CType = uice_addtohomescreen
                }
            }
            kachel_teaser {
                iconIdentifier = tx_uice_kachel_teaser
                title = LLL:EXT:ui_ce/Resources/Private/Language/locallang_db_new_content_el.xlf:wizards.newContentElement.kachel_teaser_title
                description = LLL:EXT:ui_ce/Resources/Private/Language/locallang_db_new_content_el.xlf:wizards.newContentElement.kachel_teaser_description
                tt_content_defValues {
                    CType = uice_kachel_teaser
                }
            }
            text_btn {
                iconIdentifier = tx_uice_text_btn
                title = LLL:EXT:ui_ce/Resources/Private/Language/locallang_db_new_content_el.xlf:wizards.newContentElement.text_btn_title
                description = LLL:EXT:ui_ce/Resources/Private/Language/locallang_db_new_content_el.xlf:wizards.newContentElement.text_btn_description
                tt_content_defValues {
                    CType = uice_text_btn
                }
            }
            text_image {
                iconIdentifier = tx_uice_text_image
                title = LLL:EXT:ui_ce/Resources/Private/Language/locallang_db_new_content_el.xlf:wizards.newContentElement.text_image_title
                description = LLL:EXT:ui_ce/Resources/Private/Language/locallang_db_new_content_el.xlf:wizards.newContentElement.text_image_description
                tt_content_defValues {
                    CType = uice_text_image
                }
            }
    }
    show := addToList(addtohomescreen, kachel_teaser, text_btn, text_image)
}
