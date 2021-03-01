<?php

namespace Yan9\Orderforys\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yan9\Orderforys\Cores\ToolUtil;
use Yan9\Orderforys\Cores\YouShuHttpUtil;
use Yan9\Orderforys\Cores\YsConfig;
use Yan9\Orderforys\Cores\CrmService;

/**
 * 微信上报处理
 * Class AddVisitPageController
 * @package Yan9\Orderforys\Controllers
 */
class AddVisitPageController extends Controller
{
    const URL_ADD_WXAPP_VISIT_PAGE = 'add_wxapp_visit_page';

    private $ysConfig;

    public function __construct()
    {
        $this->ysConfig = new YsConfig();
    }

    /**
     * Action:上报
     * @return array|bool|mixed
     *
     * Date: 2021/2/26
     */
    public function addVisitPage($rawMsg, $dataSourceId)
    {
        try {
            if (empty($rawMsg)) {
                throw new \Exception('rawMsg 不能为空');
            }
            if (empty($dataSourceId)) {
                throw new \Exception('dataSourceId 不能为空');
            }
            $url = $this->ysConfig->getUrl(self::URL_ADD_WXAPP_VISIT_PAGE);
            $params['dataSourceId'] = $dataSourceId;
            $params['rawMsg'][] = $rawMsg;
            return YouShuHttpUtil::post($url, $params);
        } catch (\Exception $exception) {
           return ToolUtil::errorResponse($exception->getMessage());
        }
    }
}
