#!/usr/bin/env zsh

prev_commit=$(git log --oneline | head -n 1)
prev_commit_hash="$(echo $prev_commit | awk '{print $1}')"
log_file="./storage/logs/deploy_$prev_commit_hash.log"

aws s3 sync ./output s3://chrisdempewolf.com --color on --exclude "*.woff2" --exclude "*.otf" --delete | tee -a "$log_file"
