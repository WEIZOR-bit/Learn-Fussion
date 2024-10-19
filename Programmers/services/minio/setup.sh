#!/bin/bash

# Read environment variables or set defaults
: "${MINIO_ROOT_USER:=minioadmin}"                        # Default root user for MinIO
: "${MINIO_ROOT_PASSWORD:=minioadmin}"           # Default root password for MinIO
: "${MINIO_API_USER:=apiuser}"
: "${MINIO_API_USER_SECRET_KEY:=zNiVQYDsdtfHQFYpyRaD}"  # Default API user secret key
: "${MINIO_BUCKET_PUBLIC:=public}"                  # Name of the public bucket
: "${MINIO_BUCKET_PRIVATE:=private}"                # Name of the private bucket
: "${MINIO_BUCKET_AVATARS:=avatars}"                # Name of the avatars bucket

# Wait for MinIO to start
while ! mc alias set local http://localhost:9000 "$MINIO_ROOT_USER" "$MINIO_ROOT_PASSWORD" >/dev/null 2>&1; do
    printf '.'
    sleep 5
done

# Create bucket aliases
mc alias set local http://localhost:9000 "$MINIO_ROOT_USER" "$MINIO_ROOT_PASSWORD"

# Create buckets using the specified names
mc mb local/"$MINIO_BUCKET_AVATARS"                # Create avatars bucket
mc mb local/"$MINIO_BUCKET_PUBLIC"                  # Create public bucket
mc mb local/"$MINIO_BUCKET_PRIVATE"                 # Create private bucket

# Create the apiuser with the secret key
mc admin user add local "$MINIO_API_USER" "$MINIO_API_USER_SECRET_KEY"

# Attach policies for apiuser
mc admin policy attach local readwrite --user apiuser    # Attach readwrite policy to apiuser

# Set public access for avatars and public buckets
mc anonymous set download local/"$MINIO_BUCKET_AVATARS"   # Allow anonymous download for avatars
mc anonymous set download local/"$MINIO_BUCKET_PUBLIC"     # Allow anonymous download for public bucket

# Set private access for the private bucket (no anonymous access)
mc policy set none local/"$MINIO_BUCKET_PRIVATE"           # Set private access for the private bucket
