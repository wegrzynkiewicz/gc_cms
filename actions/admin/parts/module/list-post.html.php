<?php

setNotice(trans('Ustawienia kafelków zostały zapisane.'));
GC\Response::redirect($breadcrumbs->getLastUrl());
