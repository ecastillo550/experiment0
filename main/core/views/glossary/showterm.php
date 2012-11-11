<div id="wrapper_glossary_content">
    <div id="glossarylist">
        <div style="height:370px;">
                    <table width="100%" align="left">
                    <tbody><tr><td valign="top" align="left">
                    <div align="center" class="quiz_content_actions" style="margin:0px;width:80%;">A - Z</div>
                    </td></tr>
                    <tr><td>
                     <?php

                     if (count($glossaryList) > 0) {
                         foreach ($glossaryList as $glossaryinfo) {
                             echo '<a href="'.  api_get_self().'?'.  api_get_cidreq().'&id='.$glossaryinfo['id'].'&action=showterm">'.Display::return_icon('pixel.gif',$glossaryinfo['name'], array('class' => 'actionplaceholdericon actionpreview')).' '.$glossaryinfo['name'].'</a><br/><br/>';
                         }
                     } else {
                         echo get_lang('ThereAreNoDefinitionsHere');
                     }

                     ?>
                    </td></tr>
                    </tbody>
                    </table>
                    <div class="pager" align="center"><?php echo $pagerLinks; ?></div>
        </div>
    </div>
    <div id="whiteboard">
        <div id="wrapper_glossary_form">
            <div id="glossary_form">
                <div align="center" class="quiz_content_actions"><?php echo $glossary_tittle; ?></div>
                <div align="center" style="overflow:auto;text-align:left;" class="quiz_content_actions glossary_description_height">
                    <?php echo $glossary_comment; ?>
                </div>
                    <?php if (api_is_allowed_to_edit()) { ?>
                <div align="right" style="border:none;" class="quiz_content_actions">
                    <a href="<?php echo api_get_self().'?'.  api_get_cidreq().'&id='.$glossary_id.'&action=edit' ?>">
                        <?php echo Display::return_icon('pixel.gif', get_lang('Edit'), array('class' => 'actionplaceholdericon actionedit')); ?>&nbsp;&nbsp;
                    </a>
                    <a <?php echo 'onclick="javascript:if(!confirm('."'".addslashes(api_htmlentities(get_lang("ConfirmYourChoice"),ENT_QUOTES,$charset))."'".')) return false;"'; ?> href="<?php echo api_get_self().'?'.  api_get_cidreq().'&id='.$glossary_id.'&action=delete' ?>">
                        <?php echo Display::return_icon('pixel.gif', get_lang('Delete'), array('class' => 'actionplaceholdericon actiondelete')); ?>
                    </a>
                </div>
                     <?php } ?>
            </div>
                    <div id="glossary_image_map">
                        <a href="<?php echo api_get_self().'?'.  api_get_cidreq(); ?>"><img style="margin:30px 30px 0 0; right:0; top:0;" src="../.././../img/imagemap90.png" class="abs"></a>
                    </div>
        </div>
    </div>
    <div id="glossary_image">
            <img style="margin:0 0px 50px 0; right:0; bottom:0;" src="../.././../img/instructor_analysis.png" class="abs">
    </div>
</div>