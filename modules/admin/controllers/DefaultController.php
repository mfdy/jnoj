<?php

namespace app\modules\admin\controllers;

use Yii;
use app\components\SystemInfo;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        // Allow users, moderators and admins to create
                        'roles' => [
                            User::ROLE_ADMIN
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->request->get('method') == 'sysinfo') {
            return json_encode([
                'stat' => SystemInfo::getStat(),
                'stime' => date('Y-m-d H:i:s'),
                'uptime' => SystemInfo::getUpTime(),
                'tempinfo' => SystemInfo::getTempInfo(),
                'meminfo' => SystemInfo::getMemInfo(),
                'loadavg' => SystemInfo::getLoadAvg(),
                'diskinfo' => SystemInfo::getDiskInfo(),
                'netdev' => SystemInfo::getNetDev()
            ]);
        }
        return $this->render('index', [
            'time_start' => microtime(true),
            'stat' => SystemInfo::getStat(),
            'LC_CTYPE' => setlocale(LC_CTYPE, 0),
            'uname' => php_uname(),
            'stime' => date('Y-m-d H:i:s'),
            'distname' => SystemInfo::getDistName(),
            'server_addr' => SystemInfo::getServerAddr(),
            'remote_addr' => SystemInfo::getRemoteAddr(),
            'uptime' => SystemInfo::getUpTime(),
            'cpuinfo' => SystemInfo::getCpuInfo(),
            'tempinfo' => SystemInfo::getTempInfo(),
            'meminfo' => SystemInfo::getMemInfo(),
            'loadavg' => SystemInfo::getLoadAvg(),
            'diskinfo' => SystemInfo::getDiskInfo(),
            'netdev' => SystemInfo::getNetDev()
        ]);
    }
}
