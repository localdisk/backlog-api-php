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
 * @method array countIssue($projectId, $issueTypeId, $componentId, $versionId, $milestoneId, $statusId, $priorityId, $assignerId, $createdUserId, $resolutionId, $parent_child_issue, $created_on_min, $created_on_max, $updated_on_min, $updated_on_max, $start_date_min, $start_date_max, $due_date_min, $due_date_max, $query, $file, $custom_fields ) 指定した条件に該当する課題件数を返します
 */
class Api
{

    /**
     * Base Url
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * User Name
     * 
     * @var string
     */
    protected $user;

    /**
     * Password
     * 
     * @var string
     */
    protected $password;

    /**
     * Constructor
     * 
     * @param string $space
     * @param string $user
     * @param string $password
     *
     * example
     *   require_once '../vendor/autoload.php';
     *   // constructor argments  space, username, password
     *   $api = new \Backlog\Api('demo', 'demo', 'demo');
     *   $res = $api->getProjects();
     *   var_dump($res);
     */
    public function __construct($space, $user, $password)
    {
        if (!isset($space) || !isset($user) || !isset($password)) {
            throw new \InvalidArgumentException('invalid argments');
        }
        $this->baseUrl  = "https://{$space}.backlog.jp/XML-RPC";
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
    public function request($method, $params= [])
    {
        $body     = xmlrpc_encode_request($method, $params);
        $client   = new Client();
        $response = $client->post($this->baseUrl, [
            'body' => $body,
            'auth' => [$this->user, $this->password]
        ]);
        return xmlrpc_decode($response->xml()->asXML());
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
        return $this->request("backlog.{$method}", $params);
    }

}
