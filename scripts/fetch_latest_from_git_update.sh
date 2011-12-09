#	Webnaplo Automated Shell Script to periodically update the current repo
#	from the server. It generally fetches the data from the 'master' branch of
#	Webnaplo from the github account. 
#
#	Project Website - https://github.com/ashwanthkumar/webnaplo
#	Author	- 	Ashwanth Kumar <ashwanth@ashwanthkumar.in>
#	Last Updated - 09/12/2011
#
#	This Script is executed everyday morning at 0900 hours to bring any latest 
#	changes made till the previous day.

# Go into the webnaplo folder
cd webnaplo

# Switch to 'master' branch to fetch the data
git checkout master

# Now pull in the latest data
git pull origin master

