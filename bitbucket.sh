#!/bin/bash
echo "Ange namn för repository på Bitbucket"
read bitbucketRepo

echo "Ange ditt användarnamn för Bitbucket"
read bitbucketUser

curl --user $bitbucketUser https://api.bitbucket.org/1.0/repositories/ \
--data name=$bitbucketRepo --data owner=careofhaus

echo "Skapar repo"
echo ""

git init
git remote add origin git@bitbucket.org:careofhaus/$bitbucketRepo.git
git add .
git commit -m "Initial commit"
git push -u origin master