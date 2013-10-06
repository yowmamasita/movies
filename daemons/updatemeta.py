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

idlist = db.movies.find({'$or':[{'lastUpdated': {'$exists': False}}, {'lastUpdated': {'$lt': datetime.datetime.utcnow() - datetime.timedelta(days=14)}}]})
finished = []
for movie_data in idlist:
    if movie_data["imdbID"] in finished:
        continue
    else:
        finished.append(movie_data["imdbID"])
        meta = get_imdb_params(movie_data["imdbID"].replace('tt', ''))
        if meta is None:
            continue
        if meta["Response"] == False:
            continue
        if "N/A" in meta["imdbRating"]:
            meta["imdbRating"] = '0'
        if "N/A" in meta["imdbVotes"]:
            meta["imdbVotes"] = '0'
        print db.movies.update({"imdbID": movie_data["imdbID"]}, {"$set": {"imdbRating": float(meta["imdbRating"]), "imdbVotes": int(meta["imdbVotes"].replace(',', '')), "lastUpdate":datetime.datetime.utcnow()}}, upsert=False, multi=True)