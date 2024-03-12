#!/usr/bin/env zsh

prev_commit=$(git log --oneline | head -n 1)
prev_commit_hash="$(echo $prev_commit | awk '{print $1}')"
log_file="./storage/logs/build_$prev_commit_hash.log"

echo "Commit = $prev_commit"
echo "Logging to $log_file"

php artisan migrate:fresh |& tee -a "$log_file"
php artisan db:seed |& tee -a "$log_file"

wget --directory-prefix=output/ --html-extension --convert-links --recursive --level=10 --page-requisites --timestamping --adjust-extension --no-host-directories http://localhost:8000 http://localhost:8000/404 |& tee -a "$log_file"

# Open external links in new tab.
# rel="noopener noreferrer" is added to avoid tabnapping
for f in $(rg 'href="http' ./output/ | rg -v 'href="https://chrisdempewolf.com' | awk -F ':' '{print $1}' | uniq); do sed -i '' 's|href="http|target="_blank" rel="noopener noreferrer" href="http|g' $f; done

# Convert 404.html links to absolute links as the 404 page won't work with relative links.
# Empty string argument to -i indicates that I don't want to create a backup file.
sed -i '' 's|href="assets/css/style.css"|href="https://chrisdempewolf.com/asfsets/css/style.css"|g' ./output/404.html
sed -i '' 's|href="assets/css/github-dark.min.css"|href="https://chrisdempewolf.com/assets/css/github-dark.min.css"|g' ./output/404.html
sed -i '' 's|src="assets/js/highlight.min.js"|src="https://chrisdempewolf.com/assets/js/highlight.min.js"|g' ./output/404.html
sed -i '' 's|href="about.html"|href="https://chrisdempewolf.com/about.html"|g' ./output/404.html
sed -i '' 's|href="resume.pdf"|href="https://chrisdempewolf.com/resume.pdf"|g' ./output/404.html
sed -i '' 's|href="tags/index.html"|href="https://chrisdempewolf.com/tags/index.html"|g' ./output/404.html

# For some reason Laravel adds this.  It is for Cloudflare, but things get wonky if I upload this.
rm -rf ./output/cdn-cgi/

# Build stats page
aws s3 sync s3://logs-cloudfront-chrisdempewolf.com cloudfront-logs/ |& tee -a "$log_file"
gunzip -c cloudfront-logs/* | goaccess -o ./output/stats.html --log-format CLOUDFRONT --time-format CLOUDFRONT --date-format CLOUDFRONT |& tee -a "$log_file"
# rg --no-filename --no-line-number 'WEBSITE.GET.OBJECT' | goaccess -o ./output/stats.html --date-format=%d/%b/%Y --time-format=%T --log-format='%^ %^ [%d:%t %^] %h %^ %^ %^ %^ "%m %U %H" %s %^ %b %^ %T %^ %R %u %^ %^ %^ %^ %^ %v %K %^ %^' |& tee -a "$log_file"


git add output | tee -a "$log_file"
git commit -am "Build: $prev_commit" | tee -a "$log_file"
git push | tee -a "$log_file"
