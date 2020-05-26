CREATE TABLE tt_content (
    tx_uice_addtohomescreen_description_android text,
    tx_uice_addtohomescreen_description_ios text,
    tx_uice_addtohomescreen_headline tinytext,
    tx_uice_kachel_teaser_cat tinytext,
    tx_uice_kachel_teaser_headline tinytext,
    tx_uice_kachel_teaser_img int(11) unsigned DEFAULT '0' NOT NULL,
    tx_uice_kachel_teaser_link tinytext,
    tx_uice_kachel_teaser_text text,
    tx_uice_text_btn_headline tinytext,
    tx_uice_text_btn_link tinytext,
    tx_uice_text_btn_texfield text,
    tx_uice_text_btn_text tinytext,
    tx_uice_text_image_align tinytext,
    tx_uice_text_image_image int(11) unsigned DEFAULT '0' NOT NULL,
    tx_uice_text_image_text text
);
