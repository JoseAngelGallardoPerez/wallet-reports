<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: permissions.proto

namespace Velmie\Wallet\Permissions;

use Google\Protobuf\Internal\GPBDecodeException;
use Http\Message\MessageFactory;
use Http\Message\StreamFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twirp\BaseServerHooks;
use Twirp\Context;
use Twirp\ErrorCode;
use Twirp\RequestHandler;
use Twirp\ServerHook;

/**
 * @see PermissionChecker
 *
 * Generated from protobuf service <code>velmie.wallet.permissions.PermissionChecker</code>
 */
final class PermissionCheckerServer implements RequestHandler
{
    const PATH_PREFIX = '/twirp/velmie.wallet.permissions.PermissionChecker/';

    /**
     * @var PermissionChecker
     */
    private $svc;

    /**
     * @var ServerHook
     */
    private $hook;

    /**
     * @param PermissionChecker $svc
     * @param ServerHooks|null    $hook
     * @param MessageFactory|null $messageFactory
     * @param StreamFactory|null  $streamFactory
     */
    public function __construct(
        PermissionChecker $svc,
        ServerHook $hook = null,
        MessageFactory $messageFactory = null,
        StreamFactory $streamFactory = null
    ) {
        parent::__construct($messageFactory, $streamFactory);

        if ($hook === null) {
            $hook = new BaseServerHooks();
        }

        $this->svc = $svc;
        $this->hook = $hook;
    }

    /**
     * Handle the request and return a response.
     *
     * @param ServerRequestInterface $req
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $req)
    {
        $ctx = $req->getAttributes();
        $ctx = Context::withPackageName($ctx, 'velmie.wallet.permissions');
        $ctx = Context::withServiceName($ctx, 'PermissionChecker');

        try {
            $ctx = $this->hook->requestReceived($ctx);
        } catch (\Twirp\Error $e) {
            return $this->writeError($ctx, $e);
        } catch (\Twirp\Exception $e) {
            return $this->writeError($ctx, $e->getError());
        } catch (\Exception $e) {
            return $this->writeError($ctx, TwirpError::errorFromException($e));
        }

        if ($req->getMethod() !== 'POST') {
            $msg = sprintf('unsupported method "%s" (only POST is allowed)', $req->getMethod());

            return $this->writeError($ctx, $this->badRoute($msg, $req->getMethod(), $req->getUri()->getPath()));
        }

        switch ($req->getUri()->getPath()) {
            case '/twirp/velmie.wallet.permissions.PermissionChecker/Check':
                return $this->handleCheck($ctx, $req);
            case '/twirp/velmie.wallet.permissions.PermissionChecker/CheckAll':
                return $this->handleCheckAll($ctx, $req);
            case '/twirp/velmie.wallet.permissions.PermissionChecker/GetGroupsByIds':
                return $this->handleGetGroupsByIds($ctx, $req);

            default:
                return $this->writeError($ctx, $this->noRouteError($req));
        }
    }

    private function handleCheck(array $ctx, ServerRequestInterface $req)
    {
        $header = $req->getHeaderLine('Content-Type');
        $i = strpos($header, ';');

        if ($i === false) {
            $i = strlen($header);
        }

        switch (trim(strtolower(substr($header, 0, $i)))) {
            case 'application/json':
                return $this->handleCheckJson($ctx, $req);

            case 'application/protobuf':
                return $this->handleCheckProtobuf($ctx, $req);

            default:
                $msg = sprintf('unexpected Content-Type: "%s"', $req->getHeaderLine('Content-Type'));

                return $this->writeError($ctx, $this->badRoute($msg, $req->getMethod(), $req->getUri()->getPath()));
        }
    }

    private function handleCheckJson(array $ctx, ServerRequestInterface $req)
    {
        $ctx = Context::withMethodName($ctx, 'Check');

        try {
            $ctx = $this->hook->requestRouted($ctx);

            $in = new \Velmie\Wallet\Permissions\PermissionReq();
            $in->mergeFromJsonString((string)$req->getBody());

            $out = $this->svc->Check($ctx, $in);

            if ($out === null) {
                return $this->writeError($ctx, TwirpError::newError(ErrorCode::Internal, 'received a null response while calling Check. null responses are not supported'));
            }

            $ctx = $this->hook->responsePrepared($ctx);
        } catch (GPBDecodeException $e) {
            return $this->writeError($ctx, TwirpError::newError(ErrorCode::Internal, 'failed to parse request json'));
        } catch (\Twirp\Error $e) {
            return $this->writeError($ctx, $e);
        } catch (\Twirp\Exception $e) {
            return $this->writeError($ctx, $e->getError());
        } catch (\Exception $e) {
            return $this->writeError($ctx, TwirpError::errorFromException($e));
        }

        $data = $out->serializeToJsonString();

        $body = $this->streamFactory->createStream($data);

        $resp = $this->messageFactory
            ->createResponse(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);

        $this->callResponseSent($ctx);

        return $resp;
    }

    private function handleCheckProtobuf(array $ctx, ServerRequestInterface $req)
    {
        $ctx = Context::withMethodName($ctx, 'Check');

        try {
            $ctx = $this->hook->requestRouted($ctx);

            $in = new \Velmie\Wallet\Permissions\PermissionReq();
            $in->mergeFromString((string)$req->getBody());

            $out = $this->svc->Check($ctx, $in);

            if ($out === null) {
                return $this->writeError($ctx, TwirpError::newError(ErrorCode::Internal, 'received a null response while calling Check. null responses are not supported'));
            }

            $ctx = $this->hook->responsePrepared($ctx);
        } catch (GPBDecodeException $e) {
            return $this->writeError($ctx, TwirpError::newError(ErrorCode::Internal, 'failed to parse request proto'));
        } catch (\Twirp\Error $e) {
            return $this->writeError($ctx, $e);
        } catch (\Twirp\Exception $e) {
            return $this->writeError($ctx, $e->getError());
        } catch (\Exception $e) {
            return $this->writeError($ctx, TwirpError::errorFromException($e));
        }

        $data = $out->serializeToString();

        $body = $this->streamFactory->createStream($data);

        $resp = $this->messageFactory
            ->createResponse(200)
            ->withHeader('Content-Type', 'application/protobuf')
            ->withBody($body);

        $this->callResponseSent($ctx);

        return $resp;
    }
    private function handleCheckAll(array $ctx, ServerRequestInterface $req)
    {
        $header = $req->getHeaderLine('Content-Type');
        $i = strpos($header, ';');

        if ($i === false) {
            $i = strlen($header);
        }

        switch (trim(strtolower(substr($header, 0, $i)))) {
            case 'application/json':
                return $this->handleCheckAllJson($ctx, $req);

            case 'application/protobuf':
                return $this->handleCheckAllProtobuf($ctx, $req);

            default:
                $msg = sprintf('unexpected Content-Type: "%s"', $req->getHeaderLine('Content-Type'));

                return $this->writeError($ctx, $this->badRoute($msg, $req->getMethod(), $req->getUri()->getPath()));
        }
    }

    private function handleCheckAllJson(array $ctx, ServerRequestInterface $req)
    {
        $ctx = Context::withMethodName($ctx, 'CheckAll');

        try {
            $ctx = $this->hook->requestRouted($ctx);

            $in = new \Velmie\Wallet\Permissions\PermissionsReq();
            $in->mergeFromJsonString((string)$req->getBody());

            $out = $this->svc->CheckAll($ctx, $in);

            if ($out === null) {
                return $this->writeError($ctx, TwirpError::newError(ErrorCode::Internal, 'received a null response while calling CheckAll. null responses are not supported'));
            }

            $ctx = $this->hook->responsePrepared($ctx);
        } catch (GPBDecodeException $e) {
            return $this->writeError($ctx, TwirpError::newError(ErrorCode::Internal, 'failed to parse request json'));
        } catch (\Twirp\Error $e) {
            return $this->writeError($ctx, $e);
        } catch (\Twirp\Exception $e) {
            return $this->writeError($ctx, $e->getError());
        } catch (\Exception $e) {
            return $this->writeError($ctx, TwirpError::errorFromException($e));
        }

        $data = $out->serializeToJsonString();

        $body = $this->streamFactory->createStream($data);

        $resp = $this->messageFactory
            ->createResponse(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);

        $this->callResponseSent($ctx);

        return $resp;
    }

    private function handleCheckAllProtobuf(array $ctx, ServerRequestInterface $req)
    {
        $ctx = Context::withMethodName($ctx, 'CheckAll');

        try {
            $ctx = $this->hook->requestRouted($ctx);

            $in = new \Velmie\Wallet\Permissions\PermissionsReq();
            $in->mergeFromString((string)$req->getBody());

            $out = $this->svc->CheckAll($ctx, $in);

            if ($out === null) {
                return $this->writeError($ctx, TwirpError::newError(ErrorCode::Internal, 'received a null response while calling CheckAll. null responses are not supported'));
            }

            $ctx = $this->hook->responsePrepared($ctx);
        } catch (GPBDecodeException $e) {
            return $this->writeError($ctx, TwirpError::newError(ErrorCode::Internal, 'failed to parse request proto'));
        } catch (\Twirp\Error $e) {
            return $this->writeError($ctx, $e);
        } catch (\Twirp\Exception $e) {
            return $this->writeError($ctx, $e->getError());
        } catch (\Exception $e) {
            return $this->writeError($ctx, TwirpError::errorFromException($e));
        }

        $data = $out->serializeToString();

        $body = $this->streamFactory->createStream($data);

        $resp = $this->messageFactory
            ->createResponse(200)
            ->withHeader('Content-Type', 'application/protobuf')
            ->withBody($body);

        $this->callResponseSent($ctx);

        return $resp;
    }
    private function handleGetGroupsByIds(array $ctx, ServerRequestInterface $req)
    {
        $header = $req->getHeaderLine('Content-Type');
        $i = strpos($header, ';');

        if ($i === false) {
            $i = strlen($header);
        }

        switch (trim(strtolower(substr($header, 0, $i)))) {
            case 'application/json':
                return $this->handleGetGroupsByIdsJson($ctx, $req);

            case 'application/protobuf':
                return $this->handleGetGroupsByIdsProtobuf($ctx, $req);

            default:
                $msg = sprintf('unexpected Content-Type: "%s"', $req->getHeaderLine('Content-Type'));

                return $this->writeError($ctx, $this->badRoute($msg, $req->getMethod(), $req->getUri()->getPath()));
        }
    }

    private function handleGetGroupsByIdsJson(array $ctx, ServerRequestInterface $req)
    {
        $ctx = Context::withMethodName($ctx, 'GetGroupsByIds');

        try {
            $ctx = $this->hook->requestRouted($ctx);

            $in = new \Velmie\Wallet\Permissions\GroupIdsReq();
            $in->mergeFromJsonString((string)$req->getBody());

            $out = $this->svc->GetGroupsByIds($ctx, $in);

            if ($out === null) {
                return $this->writeError($ctx, TwirpError::newError(ErrorCode::Internal, 'received a null response while calling GetGroupsByIds. null responses are not supported'));
            }

            $ctx = $this->hook->responsePrepared($ctx);
        } catch (GPBDecodeException $e) {
            return $this->writeError($ctx, TwirpError::newError(ErrorCode::Internal, 'failed to parse request json'));
        } catch (\Twirp\Error $e) {
            return $this->writeError($ctx, $e);
        } catch (\Twirp\Exception $e) {
            return $this->writeError($ctx, $e->getError());
        } catch (\Exception $e) {
            return $this->writeError($ctx, TwirpError::errorFromException($e));
        }

        $data = $out->serializeToJsonString();

        $body = $this->streamFactory->createStream($data);

        $resp = $this->messageFactory
            ->createResponse(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);

        $this->callResponseSent($ctx);

        return $resp;
    }

    private function handleGetGroupsByIdsProtobuf(array $ctx, ServerRequestInterface $req)
    {
        $ctx = Context::withMethodName($ctx, 'GetGroupsByIds');

        try {
            $ctx = $this->hook->requestRouted($ctx);

            $in = new \Velmie\Wallet\Permissions\GroupIdsReq();
            $in->mergeFromString((string)$req->getBody());

            $out = $this->svc->GetGroupsByIds($ctx, $in);

            if ($out === null) {
                return $this->writeError($ctx, TwirpError::newError(ErrorCode::Internal, 'received a null response while calling GetGroupsByIds. null responses are not supported'));
            }

            $ctx = $this->hook->responsePrepared($ctx);
        } catch (GPBDecodeException $e) {
            return $this->writeError($ctx, TwirpError::newError(ErrorCode::Internal, 'failed to parse request proto'));
        } catch (\Twirp\Error $e) {
            return $this->writeError($ctx, $e);
        } catch (\Twirp\Exception $e) {
            return $this->writeError($ctx, $e->getError());
        } catch (\Exception $e) {
            return $this->writeError($ctx, TwirpError::errorFromException($e));
        }

        $data = $out->serializeToString();

        $body = $this->streamFactory->createStream($data);

        $resp = $this->messageFactory
            ->createResponse(200)
            ->withHeader('Content-Type', 'application/protobuf')
            ->withBody($body);

        $this->callResponseSent($ctx);

        return $resp;
    }

    /**
     * Writes Twirp errors in the response and triggers hooks.
     *
     * @param array        $ctx
     * @param \Twirp\Error $e
     *
     * @return ResponseInterface
     */
    protected function writeError(array $ctx, \Twirp\Error $e)
    {
        $statusCode = ErrorCode::serverHTTPStatusFromErrorCode($e->code());
        $ctx = Context::withStatusCode($ctx, $statusCode);

        try {
            $ctx = $this->hook->error($ctx, $e);
        } catch (\Exception $e) {
            // We have three options here. We could log the error, call the Error
            // hook, or just silently ignore the error.
            //
            // Logging is unacceptable because we don't have a user-controlled
            // logger; writing out to stderr without permission is too rude.
            //
            // Calling the Error hook would confuse users: it would mean the Error
            // hook got called twice for one request, which is likely to lead to
            // duplicated log messages and metrics, no matter how well we document
            // the behavior.
            //
            // Silently ignoring the error is our least-bad option. It's highly
            // likely that the connection is broken and the original 'err' says
            // so anyway.
        }

        $this->callResponseSent($ctx);

        return parent::writeError($ctx, $e);
    }

    /**
     * Triggers response sent hook.
     *
     * @param array $ctx
     */
    private function callResponseSent(array $ctx)
    {
        try {
            $this->hook->responseSent($ctx);
        } catch (\Exception $e) {
            // We have three options here. We could log the error, call the Error
            // hook, or just silently ignore the error.
            //
            // Logging is unacceptable because we don't have a user-controlled
            // logger; writing out to stderr without permission is too rude.
            //
            // Calling the Error hook could confuse users: this hook is triggered
            // by the error hook itself, which is likely to lead to
            // duplicated log messages and metrics, no matter how well we document
            // the behavior.
            //
            // Silently ignoring the error is our least-bad option. It's highly
            // likely that the connection is broken and the original 'err' says
            // so anyway.
        }
    }
}
