#!/usr/bin/env zsh

prev_commit=$(git log --oneline | head -n 1)
prev_commit_hash="$(echo $prev_commit | awk '{print $1}')"
log_file="./storage/logs/build_$prev_commit_hash.log"

echo "Commit = $prev_commit"
echo "Logging to $log_file"

php artisan migrate:fresh |& tee -a "$log_file"
php artisan db:seed |& tee -a "$log_file"

# rm -rf ./output
# mkdir ./output
wget --directory-prefix=output/ --html-extension --convert-links --recursive --level=10 --page-requisites --timestamping --adjust-extension --no-host-directories http://localhost:8000 http://localhost:8000/404 |& tee -a "$log_file"

# For some reason Laravel adds this.  It is for Cloudflare, but things get wonky if I upload this.
rm -rf ./output/cdn-cgi/

# Build stats page
aws s3 sync s3://logs-cloudfront-chrisdempewolf.com cloudfront-logs/ |& tee -a "$log_file"
gunzip -c cloudfront-logs/* | goaccess -o ./output/stats.html --log-format CLOUDFRONT --time-format CLOUDFRONT --date-format CLOUDFRONT |& tee -a "$log_file"
# rg --no-filename --no-line-number 'WEBSITE.GET.OBJECT' | goaccess -o ./output/stats.html --date-format=%d/%b/%Y --time-format=%T --log-format='%^ %^ [%d:%t %^] %h %^ %^ %^ %^ "%m %U %H" %s %^ %b %^ %T %^ %R %u %^ %^ %^ %^ %^ %v %K %^ %^' |& tee -a "$log_file"


git add output | tee -a "$log_file"
git commit -am "Build: $prev_commit" | tee -a "$log_file"
git push | tee -a "$log_file"
