# Cloud storage providers

One of the core feature of Flysystem is its ability to interact easily with remote filesystems,
including many cloud storage providers. This bundle provides the same level of support for these
cloud providers by providing corresponding adapters in the configuration.

* [Azure](#azure)
* [AsyncAws S3](#asyncaws-s3)
* [AWS S3](#aws-s3)
* [DigitalOcean Spaces](#digitalocean-spaces)
* [Scaleway Object Storage](#scaleway-object-storage)
* [Google Cloud Storage](#google-cloud-storage)
* [Rackspace](#rackspace)
* [WebDAV](#webdav)

## Azure

### Installation

```
composer require league/flysystem-azure-blob-storage
```

### Usage

```yaml
# config/packages/flysystem.yaml

flysystem:
    storages:
        users.storage:
            adapter: 'azure'
            options:
                client: 'azure_client_service' # The service ID of the MicrosoftAzure\Storage\Blob\BlobRestProxy instance
                container: 'container_name'
                prefix: 'optional/path/prefix'
```

## AsyncAws S3

### Installation

```
composer require async-aws/flysystem-s3
```

### Usage

```yaml
# config/packages/flysystem.yaml

flysystem:
    storages:
        users.storage:
            adapter: 'asyncaws'
            options:
                client: 'aws_client_service' # The service ID of the AsyncAws\S3\S3Client instance
                bucket: 'bucket_name'
                prefix: 'optional/path/prefix'
```

## AWS S3

### Installation

```
composer require league/flysystem-aws-s3-v3
```

### Usage

```yaml
# config/packages/flysystem.yaml

flysystem:
    storages:
        users.storage:
            adapter: 'aws'
            # visibility: public # Make the uploaded file publicly accessible in S3
            options:
                client: 'aws_client_service' # The service ID of the Aws\S3\S3Client instance
                bucket: 'bucket_name'
                prefix: 'optional/path/prefix'
                streamReads: true
```

## DigitalOcean Spaces

The DigitalOcean Spaces are compatible with the AWS S3 API, meaning that you can use the same configuration
as for a AWS storage.

## Scaleway Object Storage

The Scaleway Object Storage is compatible with the AWS S3 API, meaning that you can use the same configuration
as for a AWS storage.

## Dropbox

### Installation

```
composer require spatie/flysystem-dropbox
```

### Usage

```yaml
# config/packages/flysystem.yaml

flysystem:
    storages:
        users.storage:
            adapter: 'dropbox'
            options:
                client: 'dropbox_client_service' # The service ID of the Spatie\Dropbox\Client instance
                prefix: 'optional/path/prefix'
```

## Google Cloud Storage

### Installation

```
composer require superbalist/flysystem-google-storage
```

### Usage

```yaml
# config/packages/flysystem.yaml
 
flysystem:
    storages:
        users.storage:
            adapter: 'gcloud'
            options:
                client: 'gcloud_client_service' # The service ID of the Google\Cloud\Storage\StorageClient instance
                bucket: 'bucket_name'
                prefix: 'optional/path/prefix'
                api_url: 'https://storage.googleapis.com'
```

## Rackspace

### Installation

```
composer require league/flysystem-rackspace
```

### Usage

```yaml
# config/packages/flysystem.yaml
 
flysystem:
    storages:
        users.storage:
            adapter: 'rackspace'
            options:
                container: 'rackspace_container_service' # The service ID of the OpenCloud\ObjectStore\Resource\Container instance
                prefix: 'optional/path/prefix'
```

## WebDAV

### Installation

```
composer require league/flysystem-webdav
```

### Usage

```yaml
# config/packages/flysystem.yaml
 
flysystem:
    storages:
        users.storage:
            adapter: 'webdav'
            options:
                client: 'webdav_client_service' # The service ID of the Sabre\DAV\Client instance
                prefix: 'optional/path/prefix'
                use_stream_copy: false
```

## Next

[Interacting with FTP and SFTP servers](https://github.com/thephpleague/flysystem-bundle/blob/master/docs/3-interacting-with-ftp-and-sftp-servers.md)
