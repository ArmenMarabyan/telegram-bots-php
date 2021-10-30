<?php
declare(strict_types=1);

/**
 * Class TylController
 */
class TylController extends ControllerBase
{
    /**
     * @var
     */
    protected $elasticService;

    /**
     * @var
     */
    protected $telegramService;

    /**
     * Constructor
     */
    public function onConstruct()
    {
        $this->elasticService = new ElasticService($this->db);
        $this->telegramService = new TelegramService();
    }

    /**
     * Get users list
     * Todo made secure and improve for future
     */
    public function getUsersAction()
    {
        $users = $this->db->query("SELECT * FROM users ORDER BY id DESC LIMIT 10 ");
        $users = $users->fetchAll();

        echo '<pre>';
        print_r($users);die;
    }


    /**
     * todo implement logger, validation and improve
     */
    public function indexAction()
    {
//        https://api.telegram.org/bot2074761169:AAGXwmW1pKxVhbPfUZM7Y56M4inNZFHZkZQ/setWebhook?url=
        $params = $this->dispatcher->getParams();

        $bodyRaw = file_get_contents('php://input');
        $body = json_decode($bodyRaw, true);
        //todo implement logger
        file_put_contents(APP_PATH . '/storage/tmp_files/tg_data.txt', print_r($body, true) . "\n", FILE_APPEND);

        if (empty($body)) {
            echo 'fail';die;
        }

        try {
            $this->db->query("INSERT INTO users (tg_raw_data) VALUES ('$bodyRaw')");
        } catch (\Exception $e) {
            //write log
        }

        $message = $body['message']['text'];

        $chatId = $body['message']['chat']['id'];

        $messageRev = $this->telegramService->cirStrrev($message);

        $this->telegramService->sendMessage($chatId, $messageRev);

        exit('ok');
    }

}

