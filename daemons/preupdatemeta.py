from pymongo import MongoClient
import requests
import json
import datetime

client = MongoClient()
db = client.fullmoviesonyoutube

def get_imdb_params(movie_id):
    r = requests.get("http://www.omdbapi.com/?i=tt%s" % movie_id)
    if r.text.find("Incorrect IMDb ID") > -1:
        return
    else:
        return json.loads(r.text)

#{'$or':[{'lastUpdated': {'$exists': False}}, {'lastUpdated': {'$lt': datetime.datetime.utcnow() + datetime.timedelta(days=14)}}]}
idlist = db.movies.distinct('imdbID')
for movie_data in idlist:
    meta = get_imdb_params(movie_data.replace('tt', ''))
    print db.movies.update({"imdbID": movie_data}, {"$set": {"imdbRating": float(meta["imdbRating"]), "imdbVotes": int(meta["imdbVotes"].replace(',', '')), "lastUpdate":datetime.datetime.utcnow()}}, upsert=False, multi=True)