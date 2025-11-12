<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/PriceDao.php';

class PriceService extends BaseService {
    public function __construct() {
        parent::__construct(new PriceDao());
    }
}