<?php

GC\Model\Staff\Group::deleteByPrimaryId(post('group_id'));
redirect($breadcrumbs->getLast('uri'));
