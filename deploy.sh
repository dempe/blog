#!/usr/bin/env zsh

aws s3 sync ./output s3://chrisdempewolf.com --delete | tee -a "$log_file"
