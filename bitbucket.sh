#!/bin/bash
echo "Ange namn för repository på Bitbucket"
read bitbucketRepo

echo "Ange ditt användarnamn för Bitbucket"
read bitbucketUser

echo "Skapar repo"
curl --user $bitbucketUser https://api.bitbucket.org/1.0/repositories/ \
--data name=$bitbucketRepo --data owner=careofhaus

git init
git remote add origin git@bitbucket.org:careofhaus/$bitbucketRepo.git
git add .
git commit -m "Initial commit with contributors"
git push -u origin master