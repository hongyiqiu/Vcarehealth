{"type":"fluid","name":"Layout for Posts","cssframework":"bootstrap-3","template":"","parent":"header-footer","Rows":[{"Cells":[{"Rows":[{"Cells":[{"Rows":[{"Cells":[{"content":{"content":"[wpv-conditional if=\"( '[wpv-post-featured-image output=\"id\"]' ne '' )\"]\n   <div class=\"fusion-flexslider flexslider fusion-post-slideshow\">\n      <ul class=\"slides\">\n        <li class=\"flex-active-slide\">\n          <div class=\"fusion-image-wrapper fusion-image-size-fixed\" aria-haspopup=\"true\">\n            [wpv-post-featured-image size=\"full\" class=\"attachment-full size-full wp-post-image\"]\n            <div class=\"fusion-rollover\">\n              <div class=\"fusion-rollover-content\">\n                <a class=\"fusion-rollover-link\" href=\"[wpv-post-url]\">\n                  [wpml-string context=\"post-meta\"]Permalink[\/wpml-string]\n                <\/a>\n                <div class=\"fusion-rollover-sep\"><\/div>\n                <a class=\"fusion-rollover-gallery\" href=\"[wpv-post-featured-image size='full' output='url']\" data-id=\"[wpv-post-id]\" data-rel=\"iLightbox[gallery]\" data-title=\"[wpv-post-title]\" data-caption=\"[wpv-post-title]\">\n                  [wpml-string context=\"post-meta\"]Gallery[\/wpml-string]\n                <\/a>\n                <h4 class=\"fusion-rollover-title\" data-fontsize=\"13\" data-lineheight=\"19\">\n                  <a href=\"[wpv-post-url]\">\n                    [wpv-post-title]\n                  <\/a>\n                <\/h4>\n                <div class=\"fusion-rollover-categories\">\n                  [wpv-post-taxonomy type=\"category\"]\n                <\/div>\t\t\t\t\t\n              <\/div>\n            <\/div>\n          <\/div>\n        <\/li>\n      <\/ul>\n    <\/div>\n\t[\/wpv-conditional]\n<h2 class=\"entry-title fusion-post-title\">[wpv-post-title]<\/h2>","responsive_images":true,"disable_auto_p":true,"unique_id":"s374","visual_mode":false},"kind":"Cell","cell_type":"cell-text","name":"Visual Editor","cssClass":"span1","cssId":"","tag":"div","width":1,"row_divider":12,"additionalCssClasses":"","editorVisualTemplateID":"cell-text-template","id":"s374","displays-post-content":false}],"cssClass":"row-","kind":"Row","row_type":"row","layout_type":"fluid","mode":"normal","name":"Post title","cssId":"","tag":"div","width":1,"row_divider":12,"additionalCssClasses":"","editorVisualTemplateID":"","id":"376"},{"Cells":[{"content":{"unique_id":"s465"},"kind":"Cell","cell_type":"cell-post-content","name":"Post Content","cssClass":"span1","cssId":"","tag":"div","width":1,"row_divider":12,"additionalCssClasses":"","editorVisualTemplateID":"cell-post-content-template","id":"s465","displays-post-content":false}],"cssClass":"row-fluid","kind":"Row","row_type":"row","layout_type":"fluid","mode":"normal","name":"Post content","cssId":"","tag":"div","width":1,"row_divider":1,"additionalCssClasses":"","editorVisualTemplateID":"","id":"467"},{"Cells":[{"content":{"content":"<div class=\"fusion-meta-info\">\n    <div class=\"fusion-meta-info-wrapper\">\n      By \n      <span class=\"vcard\">\n        <span class=\"fn\">\n          <a href=\"[wpv-post-author format='url']\" title=\"[wpml-string context='post-meta']Posts by[\/wpml-string] [wpv-post-author]\" rel=\"author\">\n            [wpv-post-author]\n          <\/a>\n        <\/span>\n      <\/span>\n      <span class=\"fusion-inline-sep\">|<\/span>\n      <span>[wpv-post-date]<\/span>\n      <span class=\"fusion-inline-sep\">|<\/span>\n      [wpv-post-taxonomy type=\"category\"]\n      <span class=\"fusion-inline-sep\">|<\/span>\n      <span class=\"fusion-comments\">\n        <a href=\"[wpv-post-url]#respond\">[wpv-post-comments-number]<\/a>\n      <\/span>\n    <\/div>\n  <\/div>","responsive_images":true,"disable_auto_p":true,"unique_id":"s549","visual_mode":false},"kind":"Cell","cell_type":"cell-text","name":"Visual Editor 2","cssClass":"span1","cssId":"","tag":"div","width":1,"row_divider":12,"additionalCssClasses":"","editorVisualTemplateID":"cell-text-template","id":"s549","displays-post-content":false}],"cssClass":"row-fluid","kind":"Row","row_type":"row","layout_type":"fluid","mode":"normal","name":"Post meta","cssId":"","tag":"div","width":1,"row_divider":1,"additionalCssClasses":"","editorVisualTemplateID":"","id":"551"},{"Cells":[{"content":{"content":"<div class=\"about-author\">\n  <div class=\"fusion-title fusion-title-size-three sep-double\" style=\"margin-top:0px;margin-bottom:31px;\">\n    <h3 class=\"title-heading-left\">\n      [wpml-string context='post-meta']About the Author:[\/wpml-string] \n      <a href=\"[wpv-post-author format=\"url\"]\" title=\"[wpml-string context='post-meta']Posts by[\/wpml-string] [wpv-post-author]\" rel=\"author\">\n        [wpv-post-author]\n      <\/a>\n    <\/h3>\n    <div class=\"title-sep-container\">\n      <div class=\"title-sep sep-double\"><\/div>\n    <\/div>\n  <\/div>\n  <div class=\"about-author-container\">\n    <div class=\"avatar\">\n      <!-- img alt=\"\" src=\"...\" class=\"avatar avatar-72 photo\" height=\"72\" width=\"72\" -->\n    <\/div>\n    <div class=\"description\">\n      [wpv-post-author format=\"meta\" meta=\"description\"]\n    <\/div>\n  <\/div>\n<\/div>","responsive_images":true,"disable_auto_p":true,"unique_id":"s648","visual_mode":false},"kind":"Cell","cell_type":"cell-text","name":"Visual Editor 3","cssClass":"span1","cssId":"","tag":"div","width":1,"row_divider":12,"additionalCssClasses":"","editorVisualTemplateID":"cell-text-template","id":"s648","displays-post-content":false}],"cssClass":"row-fluid","kind":"Row","row_type":"row","layout_type":"fluid","mode":"normal","name":"Author info","cssId":"","tag":"div","width":1,"row_divider":1,"additionalCssClasses":"","editorVisualTemplateID":"","id":"650"},{"Cells":[{"content":{"avatar_size":"24","title_one_comment":"One thought on %TITLE%","title_multi_comments":"%COUNT% thoughts on %TITLE%","ddl_prev_link_text":"<< Older Comments","ddl_next_link_text":"Newer Comments >>","comments_closed_text":"Comments are closed","reply_text":"Reply","password_text":"This post is password protected. Enter the password to view any comments.","unique_id":"s762"},"kind":"Cell","cell_type":"comments-cell","name":"Comments","cssClass":"span1","cssId":"","tag":"div","width":1,"row_divider":12,"additionalCssClasses":"","editorVisualTemplateID":"comments-cell-template","id":"s762","displays-post-content":false}],"cssClass":"row-fluid","kind":"Row","row_type":"row","layout_type":"fluid","mode":"normal","name":"Post comments","cssId":"","tag":"div","width":1,"row_divider":1,"additionalCssClasses":"","editorVisualTemplateID":"","id":"764"}],"kind":"Container","name":"Grid of cells","cssClass":"","cssId":"","tag":"div","width":3,"row_divider":3,"additionalCssClasses":null,"editorVisualTemplateID":"","id":"372"},{"content":{"widget_area":"Blog Sidebar","unique_id":"s259"},"kind":"Cell","cell_type":"cell-widget-area","name":"Widget Area","cssClass":"span1","cssId":"","tag":"div","width":1,"row_divider":3,"additionalCssClasses":"","editorVisualTemplateID":"cell-widget-area-template","id":"s259","displays-post-content":false}],"cssClass":"row-","kind":"Row","row_type":"row","layout_type":"fluid","mode":"normal","name":"Content parts","cssId":"","tag":"div","width":1,"row_divider":3,"additionalCssClasses":"","editorVisualTemplateID":"","id":"261"}],"kind":"Container","name":"Grid of cells","cssClass":"","cssId":"","tag":"div","width":12,"row_divider":1,"additionalCssClasses":null,"editorVisualTemplateID":"","id":"251"}],"cssClass":"row-fluid","kind":"Row","row_type":"row","layout_type":"fluid","mode":"normal","name":"Post contents","cssId":"","tag":"div","width":1,"row_divider":1,"additionalCssClasses":"layouts-content","editorVisualTemplateID":"","id":"101"}],"width":12,"cssClass":"span12","kind":"Layout","has_child":false,"slug":"posts","has_loop":false,"has_post_content_cell":true,"cssId":"","tag":"div","row_divider":1,"additionalCssClasses":"","editorVisualTemplateID":"","post_types":{"post":true},"archives":[],"posts":[],"layout_type":"normal"}