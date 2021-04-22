# Velmie Wallet Reports Service

Set env variables:
```
ENV                          - environment for app. Default: development
VELMIE_WALLET_USERS_DB_PASS             - user service detabase password. Default: root
VELMIE_WALLET_USERS_DB_USER                 - user service detabase username. Default: root
VELMIE_WALLET_USERS_DB_NAME               - user service database scheme name. Defaul: Velmie Wallet
VELMIE_WALLET_USERS_DB_PORT                 - user service database port. Default: 3306
VELMIE_WALLET_USERS_DB_HOST                 - user service database host. Default: localhost
VELMIE_WALLET_USERS_DB_DRIV               - user service database driver. Default: mysql

VELMIE_WALLET_CURRENCIES_DB_PASS        - user service detabase password. Default: root
VELMIE_WALLET_CURRENCIES_DB_USER            - user service detabase username. Default: root
VELMIE_WALLET_CURRENCIES_DB_NAME          - user service database scheme name. Defaul: Velmie Wallet
VELMIE_WALLET_CURRENCIES_DB_PORT            - user service database port. Default: 3306
VELMIE_WALLET_CURRENCIES_DB_HOST            - user service database host. Default: localhost
VELMIE_WALLET_CURRENCIES_DB_DRIV          - user service database driver. Default: mysql

VELMIE_WALLET_ACCOUNTS_DB_PASS          - user service detabase password. Default: root
VELMIE_WALLET_ACCOUNTS_DB_USER              - user service detabase username. Default: root
VELMIE_WALLET_ACCOUNTS_DB_NAME            - user service database scheme name. Defaul: Velmie Wallet
VELMIE_WALLET_ACCOUNTS_DB_PORT              - user service database port. Default: 3306
VELMIE_WALLET_ACCOUNTS_DB_HOST              - user service database host. Default: localhost
VELMIE_WALLET_ACCOUNTS_DB_DRIV            - user service database driver. Default: mysql
```

### Adjusting PHP in container environment variables:
**PHP_INI_MEMORY_LIMIT** (default: 128MB)
```
Maximum amount of memory a script may consume
http://php.net/memory-limit
```
            
**PHP_INI_MAX_EXECUTION_TIME** (default: 30)
```
Maximum execution time of each script, in seconds
http://php.net/max-execution-time
```	
          
**PHP_INI_MAX_INPUT_TIME** (default: 60)
```
Maximum amount of time each script may spend parsing request data. It's a good
idea to limit this time on productions servers in order to eliminate unexpectedly
long running scripts.
Default Value: -1 (Unlimited)
Development Value: 60 (60 seconds)
Production Value: 60 (60 seconds)
http://php.net/max-input-time
```
          
**PHP_INI_DISPLAY_ERRORS** (default: Off)
```
This directive controls whether or not and where PHP will output errors,
notices and warnings too. Error output is very useful during development, but
it could be very dangerous in production environments. Depending on the code
which is triggering the error, sensitive information could potentially leak
out of your application such as database usernames and passwords or worse.
For production environments, we recommend logging errors rather than
sending them to STDOUT.
Possible Values:
  Off = Do not display any errors
  stderr = Display errors to STDERR (affects only CGI/CLI binaries!)
  On or stdout = Display errors to STDOUT
Default Value: On
Development Value: On
Production Value: Off
http://php.net/display-errors
```

**PHP_INI_POST_MAX_SIZE** (default: 8M)
```
Maximum size of POST data that PHP will accept.
Its value may be 0 to disable the limit. It is ignored if POST data reading
is disabled through enable_post_data_reading.
http://php.net/post-max-size
```        

**PHP_INI_FILE_UPLOADS** (default: On)
```
Whether to allow HTTP file uploads.
http://php.net/file-uploads
```        
    
**PHP_INI_UPLOAD_MAX_FILESIZE** (default: 2M)
```
Maximum allowed size for uploaded files.
http://php.net/upload-max-filesize
```

**PHP_INI_MAX_FILE_UPLOADS** (default: 20)
```
Maximum number of files that can be uploaded via a single request
```           
            
#### [OPCache]            
**PHP_OPCACHE_ENABLE** (default: 1)
```
Determines if Zend OPCache is enabled
```
    
**PHP_OPCACHE_MEMORY_CONSUMPTION** (default: 128)
```
The OPcache shared memory storage size.
```
                                           
**PHP_OPCACHE_MAX_ACCELERATED_FILES** (default: 10000)
```
The maximum number of keys (scripts) in the OPCache hash table.
Only numbers between 200 and 1000000 are allowed.
``` 
                                           
**PHP_OPCACHE_MAX_WASTED_PERCENTAGE** (default: 5)
```
The maximum percentage of "wasted" memory until a restart is scheduled.
```
                                           
**PHP_OPCACHE_REVALIDATE_FREQ** (default: 15)
```
How often (in seconds) to check file timestamps for changes to the shared
memory storage allocation. ("1" means validate once per second, but only
once per request. "0" means always validate)
```                                          

## Wallet Reports Helm chart configuration

For usage examples and tips see [this article](https://velmie.atlassian.net/wiki/spaces/WAL/pages/52004603/Wallet-+Helm+charts+getting+started).

The following table lists the configurable parameters of the wallet-reports chart, and their default values.

| Parameter                      | Description                                                                                                                      | Default                                 |
|--------------------------------|----------------------------------------------------------------------------------------------------------------------------------|:---------------------------------------:|
| service.type                   | The type of a service e.g. ClusterIp, NodePort, LoadBalancer                                                                     | ClusterIp                               |
| service.ports.public           | Application public API port.                                                                                                     | 10308                                   |
| service.ports.rpc              | Application RPC port.                                                                                                            | 12308                                   |
| service.ports.unsafeExposeRPC  | Forces to expose RPC port even if service.type other than ClusterIp                                                              | false                                   |
| service.selectors              | List of additional selectors                                                                                                     | {}                                      |
| containerPorts                 | List of ports that should be exposed on application container but in the service object.                                         | []                                      |
| containerLivenessProbe.enabled | Determines whether liveness probe should be performed on a pod.                                                                  |                                         |
| containerLivenessProbe.failureThreshold | Number of requests that should be failed in order to treat container unhealthy                                          | 5                                       |
| containerLivenessProbe.periodSeconds | Number of seconds between check requests.                                                                                  | 15                                      |
| appApiPathPrefix               | API prefix path. Used with internal health check functionality.                                                                  | reports                              |
| mysqlAdmin.user                | Privileged database user name. Used in order to create DB schema and user. Required if hooks.dbInit.enabled=true.                |                                         |
| mysqlAdmin.password            | Privileged database user password.                                                                                               |                                         |
| hooks.dbInit.enabled           | Enabled database init job.                                                                                                       | false                                   |
| hooks.dbInit.createSchema      | Determines whether to create database schema. Depends on hooks.dbInit.enabled                                                    | true                                    |
| hooks.dbInit.createUser        | Determines whether to create database user that will be restricted to only use specified database schema.                        | true                                    |
| hooks.dbMigration.enabled      | Determines whether to run database migrations.                                                                                   |                                         |
| ingress.enabled                | Determines whether to create ingress resource for the service.                                                                   | true                                    |
| ingress.annotations            | List of additional annotations for the ingress.                                                                                  | {"kubernetes.io/ingress.class": "nginx"}|
| ingress.tls.enabled            | Determines whether TLS (https) connection should be set.                                                                         | false                                   |
| ingress.tls.host               | Host name that is covered by a certificate. This value is required if ingress.tls.enabled=true.                                  |                                         |
| ingress.tls.secretName         | [Kubernetes secret](https://kubernetes.io/docs/concepts/services-networking/ingress/#tls) name where TLS certificate is stored.  |                                         |
| appEnv.corsMethods             | Access-Control-Allow-Methods header that will be returned by the application.                                                    | GET,POST,PUT,OPTIONS                    |
| appEnv.corsOrigins             | Access-Control-Allow-Origin header that will be returned by the application.                                                     | *                                       |
| appEnv.corsHeaders             | Access-Control-Allow-Headers header that will be returned by the application.                                                    | *                                       |
| appEnv.dbHost                  | Database host to which application will be connected                                                                             | mysql                                   |
| appEnv.dbPort                  | Application database port.                                                                                                       | 3306                                    |
| appEnv.dbUser                  | Application database user.                                                                                                       |                                         |
| appEnv.dbName                  | Application database name.                                                                                                       |                                         |
| phpIni.memoryLimit             | Maximum amount of memory a script may consume. [See details](http://php.net/memory-limit)                                        | "128M"                                  |
| phpIni.maxExecutionTime        | Maximum execution time of each script, in seconds [See details](http://php.net/max-execution-time)                               | 30                                      |
| phpIni.maxInputTime            | Maximum amount of time each script may spend parsing request data. [See details](http://php.net/max-input-time)                  | 60                                      |
| phpIni.displayErrors           | This directive controls whether or not and where PHP will output errors, notices and warnings too [See details](http://php.net/display-errors) | "Off"                     |
| phpIni.postMaxSize             | Maximum size of POST data that PHP will accept. [See details](http://php.net/post-max-size)                                      | "8M"                                    |
| phpIni.fileUploads             | Whether to allow HTTP file uploads. [See details](http://php.net/file-uploads)                                                   | "On"                                    |
| phpIni.uploadMaxFilesize       | Maximum allowed size for uploaded files. [See details](http://php.net/upload-max-filesize)                                       | "2M                                     |
| phpIni.maxFileUploads          | Maximum number of files that can be uploaded via a single request.                                                               | "20"                                    |
| phpIni.opcacheEnable           | Determines if Zend OPCache is enabled                                                                                            | "1"                                     |
| phpIni.opcacheMemoryConsumption| The OPcache shared memory storage size.                                                                                          | "128"                                   |
| phpIni.opcacheMaxAcceleratedFiles| The maximum number of keys (scripts) in the OPCache hash table. Only numbers between 200 and 1000000 are allowed.              | "10000"                                 |
| phpIni.opcacheMaxWastedPercentage| The maximum percentage of "wasted" memory until a restart is scheduled.                                                        | "5"                                     |
| phpIni.opcacheRevalidateFreq   | How often (in seconds) to check file timestamps for changes to the shared memory storage allocation.                             | "15"                                    |
| image.repository               | What docker image to deploy.                                                                                                     | 360021420270.dkr.ecr.eu-central-1.amazonaws.com/velmie/wallet-currencies |
| image.pullPolicy               | What image pull policy to use.                                                                                                   | IfNotPresent                             |
| image.tag                      | What docker image tag to use.                                                                                                    | {Chart.yaml - appVersion}                |
| image.dbMigrationRepository    | What docker image to run in order to execute database migrations. By default the value if image.repository + "-db-migration"     | {image.tag}-db-migration                 |
| image.dbMigrationTag           | What docker image tag should be used for the db migration image.                                                                 | Same as image.tag                        |
| imagePullSecrets               | List of secrets which contain credentials to private docker repositories.                                                        | []                                       |
| nameOverride                   | Override this chart name.                                                                                                        | wallet-reports                        |
| fullnameOverride               | Override this chart full name. By default it is composed from release name and the chart name.                                   | {releaseName}-{chartName}                |
| serviceAccount.create          | Whether Kubernetes service account resource should be created.                                                                   | false                                    |
| serviceAccount.annotations     | Annotations to add to the service account                                                                                        | {}                                       |
| serviceAccount.name            | The name of the service account to use. If not set and create is true, a name is generated using the fullname template.          | See description                          |
| podAnnotations                 | Kubernetes pod annotations.                                                                                                      | {}                                       |
| securityContext                | A security context defines privilege and access control settings for a Pod or Container. [See details](https://kubernetes.io/docs/tasks/configure-pod-container/security-context/) | {} |
| resources                      | Limit Pod computing resources. [See details](https://kubernetes.io/docs/concepts/configuration/manage-resources-containers/)             | {}                                       |
| autoscaling.enabled            | Determines whether autoscaling functionality is enabled.                                                                         | false                                    |
| autoscaling.minReplicas        | [See details](https://kubernetes.io/docs/tasks/run-application/horizontal-pod-autoscale-walkthrough/)                            | 1                                        |
| autoscaling.maxReplicas        | [See details](https://kubernetes.io/docs/tasks/run-application/horizontal-pod-autoscale-walkthrough/)                            | 5                                        |
| autoscaling.targetCPUUtilizationPercentage | [See details](https://kubernetes.io/docs/tasks/run-application/horizontal-pod-autoscale-walkthrough/)                | 80                                       |
| nodeSelector                   | [See details](https://kubernetes.io/docs/concepts/scheduling-eviction/assign-pod-node/#nodeselector)                             | {}                                       |
| tolerations                    | [See details](https://kubernetes.io/docs/concepts/scheduling-eviction/taint-and-toleration/)                                     | []                                       |
| affinity                       | [See details](https://kubernetes.io/docs/tasks/configure-pod-container/assign-pods-nodes-using-node-affinity/)                   | {}                                       |

## Run the project with Tilt

[Tilt](https://tilt.dev/) automates all the steps from a code change to a new process: watching files, building container images, and bringing your environment up-to-date.

[Install Tilt](https://docs.tilt.dev/install.html)

See [this article](https://velmie.atlassian.net/wiki/spaces/WAL/pages/56001240/Running+core+services+with+Tilt) which explains how to work with Tilt regarding this project.
