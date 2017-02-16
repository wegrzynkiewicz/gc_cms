<?php

require ACTIONS_PATH."/admin/parts/module/type/photo/_import.php";

flashBox($trans('Kolejność zakładek została zaktualizowana.'));
redirect($breadcrumbs->getLast('uri'));
