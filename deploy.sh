#!/usr/bin/env zsh

prev_commit=$(git log --oneline | head -n 1)
prev_commit_hash="$(echo $prev_commit | awk '{print $1}')"
log_file="./storage/logs/build_$prev_commit_hash.log"

aws s3 sync ./output s3://chrisdempewolf.com --delete | tee -a "$log_file"
