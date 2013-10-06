from pymongo import MongoClient
import requests
import json

client = MongoClient()
db = client.fullmoviesonyoutube
ii = 0
for movie_data in db.movies.find(timeout=False):
    ii += 1
    ss = requests.get('http://img.youtube.com/vi/'+movie_data["youtubeId"]+'/3.jpg')
    if ss.status_code == 404:
    	print "404: %s - %s (http://img.youtube.com/vi/%s/3.jpg)" % (movie_data["movieTitle"], movie_data["youtubeUrl"], movie_data["youtubeId"])
        db.removedvids.insert({ "imdbUrl":movie_data["imdbUrl"], "youtubeId":movie_data["youtubeId"], "youtubeUrl":movie_data["youtubeUrl"], "youtubeDuration":movie_data["youtubeDuration"], "moviePlot":movie_data["moviePlot"], "movieRated":movie_data["movieRated"], "movieTitle":movie_data["movieTitle"], "moviePoster":movie_data["moviePoster"], "movieWriter":movie_data["movieWriter"], "movieResponse":movie_data["movieResponse"], "movieDirector":movie_data["movieDirector"], "movieReleased":movie_data["movieReleased"], "movieActors":movie_data["movieActors"], "movieYear":movie_data["movieYear"], "movieGenre":movie_data["movieGenre"], "movieRuntime":movie_data["movieRuntime"], "movieType":movie_data["movieType"], "imdbRating":movie_data["imdbRating"], "imdbVotes":movie_data["imdbVotes"], "imdbID":movie_data["imdbID"] })
        db.movies.remove({'youtubeId':movie_data["youtubeId"]})
        continue
    r = requests.get("http://www.omdbapi.com/?i=%s" % movie_data["imdbID"])
    imdb_data = json.loads(r.text)
    if imdb_data["Type"] != "movie":
    	print "Not movie: %s - http://www.imdb.com/title/%s/" % (movie_data["movieTitle"], movie_data["imdbID"])
        db.removedvids.insert({ "imdbUrl":movie_data["imdbUrl"], "youtubeId":movie_data["youtubeId"], "youtubeUrl":movie_data["youtubeUrl"], "youtubeDuration":movie_data["youtubeDuration"], "moviePlot":movie_data["moviePlot"], "movieRated":movie_data["movieRated"], "movieTitle":movie_data["movieTitle"], "moviePoster":movie_data["moviePoster"], "movieWriter":movie_data["movieWriter"], "movieResponse":movie_data["movieResponse"], "movieDirector":movie_data["movieDirector"], "movieReleased":movie_data["movieReleased"], "movieActors":movie_data["movieActors"], "movieYear":movie_data["movieYear"], "movieGenre":movie_data["movieGenre"], "movieRuntime":movie_data["movieRuntime"], "movieType":movie_data["movieType"], "imdbRating":movie_data["imdbRating"], "imdbVotes":movie_data["imdbVotes"], "imdbID":movie_data["imdbID"] })
        db.movies.remove({'youtubeId':movie_data["youtubeId"]})
        continue
print ii