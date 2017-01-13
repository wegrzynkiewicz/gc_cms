<?php

GC\Model\Staff\Group::deleteByPrimaryId(post('group_id'));
GC\Response::redirect($breadcrumbs->getLastUrl());
