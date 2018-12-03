<?php

namespace SMSPilot;

/**
 * @link https://smspilot.ru/apikey.php#err
 * @package SMSPilot
 */
class SMSPilotErrorEnum
{
    CONST SUCCESS = 0;
    CONST INPUT_DATA_IS_REQUIRED = 10;
    CONST UNKNOWN_INPUT_FORMAT = 11;
    CONST XML_STRUCTURE_IS_INVALID = 12;
    CONST JSON_STRUCTURE_IS_INVALID = 13;
    CONST UNKNOWN_COMMAND = 14;
    CONST APIKEY_IS_REQUIRED = 100;
    CONST APIKEY_IS_INVALID = 101;
    CONST APIKEY_NOT_FOUND = 102;
    CONST USER_IS_BLOCKED_BALANCE = 105;
    CONST USER_IS_BLOCKED_SPAM = 106;
    CONST USER_IS_BLOCKED_UNTRUSTED = 107;
    CONST PHONE_IS_REQUIRED = 108;
    CONST SYSTEM_ERROR = 110;
    CONST INVALID_PHONE = 111;
    CONST NO_MONEY = 112;
    CONST IP_RESTRICTION = 113;
    CONST INVALID_SENDER = 115;
    CONST SENDER_FROM_IS_REQUIRED = 200;
    CONST SENDER_FROM_IS_INVALID = 201;
    CONST SENDER_FROM_IS_UNREGISTERED = 204;
    CONST PHONE_IN_BLACK_LIST = 212;
    CONST UNSUPPORTED_OPERATOR = 213;
    CONST PHONE_IS_DUPLICATED = 214;
    CONST INVALID_PHONE_LENGTH = 215;
    CONST TEXT_IS_REQUIRED = 220;
    CONST TEXT_TOO_LONG = 221;
    CONST SPAM_PROTECTION = 223;
    CONST SPAM_PROTECTION_SENDER = 224;
    CONST SPAM_PROTECTION_DIRECT = 225;
    CONST SHARED_SENDER_DISABLED = 226;
    CONST ID_IS_INVALID = 230;
    CONST PACKET_ID_IS_INVALID = 231;
    CONST INVALID_SMS_LIST = 240;
    CONST LOOP_PROTECTION = 243;
    CONST FILTER = 247;
    CONST CYRLAT_FILTER = 248;
    CONST INVALID_SEND_DATETIME = 250;
    CONST INVALID_CALLBACK_URL = 260;
    CONST INVALID_TTL = 270;
    CONST INVALID_LIST_FIELDS = 275;
    CONST SMS_SERVER_ID_IS_REQUIRED = 300;
    CONST SMS_SERVER_ID_IS_INVALID = 301;
    CONST SMS_SERVER_ID_NOT_FOUND = 302;
    CONST INVALID_IDS_LIST = 303;
    CONST SERVER_PACKET_ID_IS_INVALID = 304;
    CONST USER_NOT_FOUND = 400;
    CONST INVALID_LOGIN_DETAILS = 401;
    CONST INVALID_FORMAT = 500;
    CONST EXPIRED = 600;
    CONST UNDELIVERABLE = 601;
    CONST DESTINATION_UNREACHABLE = 602;
    CONST REJECTED = 603;
    CONST CANCELLED = 604;
    CONST THE_RECIPIENT_HAS_DISABLED_SUCH_MESSAGES = 605;
    CONST TEMPLATE_IS_REQUIRED = 630;
    CONST TEMPLATE_TOO_LONG = 631;
    CONST TEMPLATE_EXITS = 632;
    CONST TEMPLATE_CALLBACK_IS_REQUIRED = 633;
    CONST TEMPLATE_CALLBACK_IS_INVALID = 634;
    CONST SENDER_IS_REQUIRED = 640;
    CONST SENDER_IS_INVALID = 641;
    CONST SENDER_IS_ADDED = 642;
    CONST DESCRIPTION_IS_REQUIRED = 643;
    CONST CALLBACK_IS_REQUIRED = 644;
    CONST CALLBACK_IS_INVALID = 645;

    static $ERRORS = [
        self::SUCCESS => ['en' => 'Success', 'ru' => 'Нет ошибок'],
        self::INPUT_DATA_IS_REQUIRED => ['en' => 'INPUT data is required', 'ru' => 'Нет входных данных'],
        self::UNKNOWN_INPUT_FORMAT => ['en' => 'Unknown INPUT format', 'ru' => 'Неизвестный формат'],
        self::XML_STRUCTURE_IS_INVALID => ['en' => 'XML structure is invalid', 'ru' => 'Ошибка XML'],
        self::JSON_STRUCTURE_IS_INVALID => ['en' => 'JSON structure is invalid', 'ru' => 'Ошибка JSON'],
        self::UNKNOWN_COMMAND => ['en' => 'Unknown COMMAND', 'ru' => 'Неизвестная команда'],
        self::APIKEY_IS_REQUIRED => ['en' => 'APIKEY is required', 'ru' => 'Не указан API-ключ (параметр apikey)'],
        self::APIKEY_IS_INVALID => ['en' => 'APIKEY is invalid', 'ru' => 'Неправильный API-ключ'],
        self::APIKEY_NOT_FOUND => ['en' => 'APIKEY not found', 'ru' => 'Такой API-ключ не найден в системе'],
        self::USER_IS_BLOCKED_BALANCE => ['en' => 'User is blocked (balance)', 'ru' => 'Пользователь блокирован из-за низкого баланса'],
        self::USER_IS_BLOCKED_SPAM => ['en' => 'User is blocked', 'ru' => 'Пользователь блокирован за спам/ошибки'],
        self::USER_IS_BLOCKED_UNTRUSTED => ['en' => 'User is blocked (untrusted)', 'ru' => 'Пользователь блокирован за недостоверные учетные данные / недоступна эл. почта / проблемы с телефоном'],
        self::PHONE_IS_REQUIRED => ['en' => 'Phone is required', 'ru' => 'Не указан телефон'],
        self::SYSTEM_ERROR => ['en' => 'System error', 'ru' => 'Системная ошибка'],
        self::INVALID_PHONE => ['en' => 'Invalid phone', 'ru' => 'Неправильный номер телефона'],
        self::NO_MONEY => ['en' => 'No money', 'ru' => 'Нет денег'],
        self::IP_RESTRICTION => ['en' => 'IP restriction', 'ru' => 'Недопустимый IP'],
        self::INVALID_SENDER => ['en' => 'Invalid sender', 'ru' => 'Неправильный отправитель'],
        self::SENDER_FROM_IS_REQUIRED => ['en' => 'Sender (from) is required', 'ru' => 'Не указан отправитель'],
        self::SENDER_FROM_IS_INVALID => ['en' => 'Sender (from) is invalid', 'ru' => 'Неправильный формат отправителя'],
        self::SENDER_FROM_IS_UNREGISTERED => ['en' => 'Sender (from) unregistered', 'ru' => 'Отправитель (from) не зарегистрирован, либо отключен'],
        self::PHONE_IN_BLACK_LIST => ['en' => 'Phone in black list', 'ru' => 'Телефон в черном списке'],
        self::UNSUPPORTED_OPERATOR => ['en' => 'Unsupported operator', 'ru' => 'Оператор не поддерживается'],
        self::PHONE_IS_DUPLICATED => ['en' => 'Phone is dublicated', 'ru' => 'Дубликат получателя'],
        self::INVALID_PHONE_LENGTH => ['en' => 'Invalid phone length', 'ru' => 'Неправильная длина номера телефона'],
        self::TEXT_IS_REQUIRED => ['en' => 'TEXT is required', 'ru' => 'Введите текст сообщения'],
        self::TEXT_TOO_LONG => ['en' => 'TEXT too long', 'ru' => 'Текст сообщения слишком длинный'],
        self::SPAM_PROTECTION => ['en' => 'Spam protection', 'ru' => 'Защита от спама'],
        self::SPAM_PROTECTION_SENDER => ['en' => 'Spam protection (SENDER)', 'ru' => 'Защита от спама'],
        self::SPAM_PROTECTION_DIRECT => ['en' => 'Spam protection (DIRECT)', 'ru' => 'Защита от спама'],
        self::SHARED_SENDER_DISABLED => ['en' => 'Shared sender disabled', 'ru' => 'Отключены общие каналы'],
        self::ID_IS_INVALID => ['en' => 'ID is invalid', 'ru' => 'ID неправильный'],
        self::PACKET_ID_IS_INVALID => ['en' => 'PACKET_ID is invalid', 'ru' => 'PACKET_ID неправильный'],
        self::INVALID_SMS_LIST => ['en' => 'Invalid SMS list', 'ru' => 'Неправильный список SMS'],
        self::LOOP_PROTECTION => ['en' => 'Loop protection', 'ru' => 'Защита от дубликатов'],
        self::FILTER => ['en' => 'Filter', 'ru' => 'Фильтры'],
        self::CYRLAT_FILTER => ['en' => 'CyrLat filter', 'ru' => 'Кириллица и латиница в одном слове'],
        self::INVALID_SEND_DATETIME => ['en' => 'Invalid SEND_DATETIME', 'ru' => 'Неправильное время отправки send_datetime'],
        self::INVALID_CALLBACK_URL => ['en' => 'Invalid callback URL', 'ru' => 'Неправильный адрес скрипта callback'],
        self::INVALID_TTL => ['en' => 'Invalid ttl', 'ru' => 'Неправильное время жизни сообщения ttl'],
        self::INVALID_LIST_FIELDS => ['en' => 'Invalid list fields', 'ru' => 'Неправильный список полей fields'],
        self::SMS_SERVER_ID_IS_REQUIRED => ['en' => 'SMS server_id is required', 'ru' => 'server_id не указан'],
        self::SMS_SERVER_ID_IS_INVALID => ['en' => 'SMS server_id is invalid', 'ru' => 'server_id неправильный'],
        self::SMS_SERVER_ID_NOT_FOUND => ['en' => 'SMS server_id not found', 'ru' => 'SMS не найдена'],
        self::INVALID_IDS_LIST => ['en' => 'Invalid IDs list', 'ru' => 'Ошибка запроса'],
        self::SERVER_PACKET_ID_IS_INVALID => ['en' => 'SERVER_PACKET_ID is invalid', 'ru' => 'server_packet_id неправильный'],
        self::USER_NOT_FOUND => ['en' => 'User not found', 'ru' => 'Пользователь не найден'],
        self::INVALID_LOGIN_DETAILS => ['en' => 'Invalid login details', 'ru' => 'Не введен логин или пароль'],
        self::INVALID_FORMAT => ['en' => 'Invalid -since- format YYYY-MM-DD HH:II:SS', 'ru' => 'Неправильный формат параметра -since- YYYY-MM-DD HH:II:SS'],
        self::EXPIRED => ['en' => 'Expired', 'ru' => 'Просрочено'],
        self::UNDELIVERABLE => ['en' => 'Undeliverable', 'ru' => 'Невозможно доставить'],
        self::DESTINATION_UNREACHABLE => ['en' => 'Destination unreachable', 'ru' => 'Номер недоступен'],
        self::REJECTED => ['en' => 'Rejected', 'ru' => 'Отказано оператором'],
        self::CANCELLED => ['en' => 'Cancelled', 'ru' => 'Отменено'],
        self::THE_RECIPIENT_HAS_DISABLED_SUCH_MESSAGES => ['en' => 'The recipient has disabled such messages', 'ru' => 'Абонент запретил отправлять ему SMS'],
        self::TEMPLATE_IS_REQUIRED => ['en' => 'TEMPLATE is required', 'ru' => 'Введите шаблон'],
        self::TEMPLATE_TOO_LONG => ['en' => 'TEMPLATE too long', 'ru' => 'Шаблон слишком длинный'],
        self::TEMPLATE_EXITS => ['en' => 'TEMPLATE exits', 'ru' => 'Такой шаблон уже есть'],
        self::TEMPLATE_CALLBACK_IS_REQUIRED => ['en' => 'TEMPLATE callback is required', 'ru' => 'Нужен callback'],
        self::TEMPLATE_CALLBACK_IS_INVALID => ['en' => 'TEMPLATE callback is invalid', 'ru' => 'Неправильный callback'],
        self::SENDER_IS_REQUIRED => ['en' => 'Sender is required', 'ru' => 'Введите имя отправителя'],
        self::SENDER_IS_INVALID => ['en' => 'Sender is invalid', 'ru' => 'Неправильное имя отправителя'],
        self::SENDER_IS_ADDED => ['en' => 'Sender is added', 'ru' => 'Уже добавленное имя отправителя'],
        self::DESCRIPTION_IS_REQUIRED => ['en' => 'Description is required', 'ru' => 'Введите название проекта, сайт, примеры сообщений'],
        self::CALLBACK_IS_REQUIRED => ['en' => 'Callback is required (URL or email)', 'ru' => 'Нужен callback (URL или email)'],
        self::CALLBACK_IS_INVALID => ['en' => 'Callback is invalid (URL or email)', 'ru' => 'Неправильный callback (URL или email)']
    ];
}