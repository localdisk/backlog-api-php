<?php

namespace Backlog;

use GuzzleHttp\Client;

/**
 * Backlog Api
 *
 * @author localdisk
 *
 * @method array getProjects() 参加プロジェクトを返します
 * @method array getProject($projectKey) 参加プロジェクトを返します
 * @method array getComponents($projectId) プロジェクトのカテゴリを返します
 * @method array getVersions($projectId) プロジェクトの発生バージョン/マイルストーンを返します
 * @method array getUsers($projectId) プロジェクトの参加メンバーを返します
 * @method array getIssueTypes($projectId) プロジェクトの種別を返します
 * @method array getComments($issueId) 課題のコメントを返します
 * @method array countIssue($projectId, $issueTypeId, $componentId, $versionId, $milestoneId, $statusId, $priorityId, $assignerId, $createdUserId, $resolutionId, $parent_child_issue, $created_on_min, $created_on_max, $updated_on_min, $updated_on_max, $start_date_min, $start_date_max, $due_date_min, $due_date_max, $query, $file, $custom_fields = []) 指定した条件に該当する課題件数を返します
 * @method array findIssue($projectId) 指定した条件に該当する課題を返します
 * @method array createIssue($projectId, $summary, $parent_issue_id, $description, $start_date, $due_date, $estimated_hours, $actual_hours, $issueTypeId, $componentId, $versionId, $milestoneId, $priorityId, $assignerId, $custom_fields = []) 課題を追加します
 * @method array updateIssue($projectId, $summary, $parent_issue_id, $description, $start_date, $due_date, $estimated_hours, $actual_hours, $issueTypeId, $componentId, $versionId, $milestoneId, $priorityId, $assignerId, $custom_fields = []) 課題を更新します
 * @method array switchStatus($key, $statusId, $assignerId, $resolutionId, $comment) 課題の状態を変更します
 * @method array addComment($key, $content) 課題にコメントを追加します
 * @method array addIssueType($project_id, $name $color) プロジェクトの課題種別を追加します
 * @method array updateIssueType($id, $name $color) プロジェクトの課題種別を更新します
 * @method array deleteIssueType($id, $substitute_id) プロジェクトの課題種別を削除します
 * @method array addVersion($project_id, $name, $start_date, $due_date) プロジェクトの発生バージョン/マイルストーンを追加します
 * @method array updateVersion($project_id, $name, $start_date, $due_date, $archived) プロジェクトの発生バージョン/マイルストーンを更新します
 * @method array deleteVersion($id) プロジェクトの発生バージョン/マイルストーンを削除します
 * @method array addComponent($project_id, $name) プロジェクトのカテゴリを追加します
 * @method array updateComponent($id, $name) プロジェクトのカテゴリを更新します
 * @method array deleteComponent($id) プロジェクトのカテゴリを削除します
 * @method array getTimeline() 参加プロジェクトすべての課題の更新情報を配列で返します(最大50件)
 * @method array getProjectSummary($projectId) プロジェクト状況を取得します
 * @method array getProjectSummaries() 全ての参加プロジェクト状況を取得します
 * @method array getUser($id) ユーザID(数値またはログインID)を指定して、ユーザを取得します
 * @method array getUserIcon($id) ユーザID(数値またはログインID)を指定して、ユーザのアイコン画像を取得します
 * @method array getActivityTypes() 課題の更新情報の種別一覧を取得します
 * @method array getStatuses() 課題の状態一覧を取得します
 * @method array getResolutions() 課題の完了理由一覧を取得します
 * @method array getPriorities() 課題の優先度一覧を取得します
 * @method array getCustomFields($projectId, $issueTypeId) プロジェクトに登録してあるカスタム属性の情報を取得します
 * @method array getChildIssues($parent_issue_id) 指定した親課題のIDの子課題を返します
 * @method array adminGetUsers() スペース内の全ユーザを取得します
 * @method array adminAddUser($user_id, $password_md5, $name, $mail_address, $role, $mail_setting = [], $icon = []) ユーザを追加します
 * @method array adminUpdateUser($id, $password_md5, $name, $mail_address, $role, $mail_setting = [], $icon = []) ユーザを更新します
 * @method array adminDeleteUsers($id) ユーザを削除します
 * @method array adminGetProjects() スペース内の全プロジェクトを取得します
 * @method array adminAddProjects($name, $key, $use_chart, $use_parent_child_issue, $text_formatting_rule) プロジェクトを追加します
 * @method array adminUpdateProjects($id, $name, $key, $use_chart, $use_parent_child_issue, $text_formatting_rule, $archived) プロジェクトを更新します
 * @method array adminDeleteProject($id) プロジェクトを削除します
 * @method array adminGetProjectUsers($project_id) プロジェクト参加ユーザリストを取得します
 * @method array adminAddProjectUser($project_id, $user_id) プロジェクト参加ユーザリストを１人追加します
 * @method array adminUpdateProjectUsers($project_id, $user_id = []) プロジェクト参加ユーザリストを一括更新します
 * @method array adminDeleteProjectUser($project_id, $user_id) プロジェクト参加ユーザリストを１人削除(不参加に)します
 * @method array adminAddCustomField($projectId, $typeId, $name, $issueTypes, $description, $required) カスタム属性を作成します
 * @method array adminUpdateCustomField($id, $name, $issueTypes, $description, $required) カスタム更新を作成します
 * @method array adminDeleteCustomField($id) カスタム削除を作成します
 *
 */
class Api
{

    /**
     * 基本URL
     * 例: https://demo.backlog.jp
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * ユーザー名
     * 
     * @var string
     */
    protected $user;

    /**
     * パスワード
     * 
     * @var string
     */
    protected $password;

    /**
     * コンストラクタ
     * 
     * @param string $baseUrl
     * @param string $user
     * @param string $password
     *
     * example
     *   require_once '../vendor/autoload.php';
     *   // constructor argments  url, username, password
     *   $api = new \Backlog\Api('https://demo.backlog.jp', 'demo', 'demo');
     *   $res = $api->getProjects();
     *   var_dump($res);
     */
    public function __construct($baseUrl, $user, $password)
    {
        if (!isset($baseUrl) || !isset($user) || !isset($password)) {
            throw new \InvalidArgumentException('invalid argments');
        }
        if ($this->endWith($baseUrl, '/')) {
            $this->baseUrl = $baseUrl . 'XML-RPC';
        } else {
            $this->baseUrl = $baseUrl . '/XML-RPC';
        }
        $this->user     = $user;
        $this->password = $password;
    }

    /**
     * Send Request
     * 
     * @param  string $method
     * @param  array $params
     * @return array
     */
    protected function request($method, $params = [])
    {
        $body     = xmlrpc_encode_request($method, $params);
        $response = (new Client)->post($this->baseUrl, [
            'body' => $body,
            'auth' => [$this->user, $this->password]
        ]);
        if ($response->getStatusCode() != 200) {
            return $response->getStatusCode();
        }
        $ret = xmlrpc_decode($response->xml()->asXML());
        if (isset($ret['faultCode'])) {
            // エラーの場合は例外を発生させる
            throw new \BadFunctionCallException($ret['faultString']);
        }
        return $ret;
    }

    /**
     * 指定した文字で終わるかどうか
     * 
     * @param string $haystack
     * @param string $needle
     * @return boolean
     */
    public function endWith($haystack, $needle)
    {
        if ($needle === substr($haystack, -strlen($needle))) {
            return true;
        }
        return false;
    }

    /**
     * 指定した文字で始まるかどうか
     * 
     * @param string $haystack
     * @param string $needle
     * @return boolean
     */
    public function startWith($haystack, $needle)
    {
        if ($needle !== '' && strpos($haystack, $needle) === 0) {
            return true;
        }
        return false;
    }

    /**
     * magic method
     * 
     * @param string $method
     * @param array $params
     * @return array
     */
    public function __call($method, $params)
    {
        // 管理者対応
        if ($this->startWith($method, 'admin')) {
            $method = 'admin.' . lcfirst(substr($method, 5));
        }
        return $this->request("backlog.{$method}", $params);
    }
}
