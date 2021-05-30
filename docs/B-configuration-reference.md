# Configuration reference

```yaml
flysystem:
    storages:
        users1.storage:
            adapter: 'aws'
            options:
                client: 'aws_client_service'
                bucket: 'bucket_name'
                prefix: 'optional/path/prefix'

        users2.storage:
            adapter: 'custom_adapter'

        users3.storage:
            adapter: 'ftp'
            options:
                host: 'ftp.example.com'
                username: 'username'
                password: 'password'
                port: 21
                root: '/path/to/root'
                passive: true
                ssl: true
                timeout: 30
                ignore_passive_address: ~

        users4.storage:
            adapter: 'gcloud'
            options:
                client: 'gcloud_client_service'
                bucket: 'bucket_name'
                prefix: 'optional/path/prefix'
                
        users5.storage:
            adapter: 'local'
            options:
                directory: '%kernel.project_dir%/storage'
                lock: 0
                skip_links: false
                permissions:
                    file:
                        public: 0744
                        private: 0700
                    dir:
                        public: 0755
                        private: 0700
            visibility: ~ # default null. Possible values are 'public' or 'private'
            case_sensitive: true
            disable_asserts: false

        users6.storage:
            adapter: 'memory'

        users7.storage:
            adapter: 'null'

        users8.storage:
            adapter: 'sftp'
            options:
                host: 'example.com'
                port: 22
                username: 'username'
                password: 'password'
                privateKey: 'path/to/or/contents/of/privatekey'
                root: '/path/to/root'
                timeout: 10

        users9.storage:
            adapter: 'lazy'
            options:
                source: 'flysystem_storage_service_to_use'

```
