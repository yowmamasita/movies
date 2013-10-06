def get_imdb_url(movie_title):
	import time
	import requests
	from bs4 import BeautifulSoup
	movie_title = movie_title.replace(' ', '+')
	i = 0;
	while(i<100):
		try:
			r = requests.get("http://www.google.com.ph/search?q=%s&start=%d" % (movie_title, i), timeout=1.5)
		except requests.exceptions.RequestException:
			i += 10
			continue
		soup = BeautifulSoup(r.text.encode("utf-8"))
		for link in soup.find_all("a"):
			href = link.get("href")
			if "/url?q=http://www.imdb.com/title/tt" in href:
				x = href.find("/", 36)
				if len(href[35:x]) > 7:
					y = 37
				else:
					y = 35
				return [href[7:x+1], href[y:x]]
		i += 10
		time.sleep(1)
	return

def get_imdb_url2(movie_title):
	import time
	import requests
	from bs4 import BeautifulSoup

	movie_title = movie_title.replace('HD', '')
	movie_title = movie_title.replace('SD', '')
	movie_title = movie_title.replace('144p', '')
	movie_title = movie_title.replace('240p', '')
	movie_title = movie_title.replace('360p', '')
	movie_title = movie_title.replace('480p', '')
	movie_title = movie_title.replace('720p', '')
	movie_title = movie_title.replace('1080p', '')
	movie_title = movie_title.replace(' subtitles', '')
	movie_title = movie_title.replace(' subtitle', '')
	movie_title = movie_title.replace(' subs', '')
	movie_title = movie_title.replace(' sub', '')
	movie_title = movie_title.replace(' ', '+')

	i = 0;
	while(i<100):
		try:
			r = requests.get("http://www.google.com.ph/search?q=%s+intitle%%3A'IMDb'&start=%d" % (movie_title, i), timeout=1.5)
		except requests.exceptions.RequestException:
			i += 10
			continue
		soup = BeautifulSoup(r.text.encode("utf-8"))
		if i==0:
			fo = open("bs.txt", "w+")
			fo.write(r.text.encode("utf-8"))
			fo.close()
		for link in soup.find_all("a"):
			href = link.get("href")
			if "/url?q=http://www.imdb.com/title/tt" in href:
				x = href.find("/", 36)
				if len(href[35:x]) > 7:
					y = 37
				else:
					y = 35
				return [href[7:x+1], href[y:x]]
		i += 10
		time.sleep(1)
	return

def get_imdb_params(movie_id):
	import requests
	import json
	r = requests.get("http://www.omdbapi.com/?i=tt%s" % movie_id)
	if r.text.find("Incorrect IMDb ID") > -1:
		return
	else:
		return json.loads(r.text)

def get_yt_id(yt_url):
	if "http://youtu.be/" in yt_url:
		# short url
		return yt_url[16:]
	elif "https://youtu.be/" in yt_url:
		return yt_url[17:]
	elif "http://www.youtube.com" in yt_url or "https://www.youtube.com" in yt_url or "http://youtube.com" in yt_url or "https://youtube.com" in yt_url:
		# long url
		y = yt_url.find("v=") + 2
		z = yt_url.find("&", y)
		if z > 0:
			return yt_url[y:z]
		else:
			return yt_url[y:]
	else:
		return

def get_yt_params(yt_id):
	import gdata.youtube.service
	try:
		yt_service = gdata.youtube.service.YouTubeService()
		yt_service.developer_key = "AI39si5SkNfY269lKxiFsHG8uP2UitT97MCGe7v-magJLO_vJRhocLWytla4_xG468wtvdaPlre8fRhano7XVUUSHryoLRSEGw"
		yt_service.client_id = "g-data_bint"
		entry = yt_service.GetYouTubeVideoEntry(video_id=yt_id)
		return {"watch":entry.media.player.url, "duration":float(entry.media.duration.seconds)}
	except gdata.service.RequestError:
		return

def db_insert(movie_data):
	from pymongo import MongoClient
	import requests
	from PIL import Image
	from StringIO import StringIO
	import os
	client = MongoClient()
	db = client.fullmoviesonyoutube
	if db.movies.find_one({"$or": [{"redditId": movie_data["redditId"]}, {"youtubeId": movie_data["youtubeId"]}]}) is None:
		if "http://ia.media-imdb.com/images/" in movie_data["moviePoster"]:
			ss = requests.get(movie_data["moviePoster"])
			i = Image.open(StringIO(ss.content))
			i.save(os.getcwd()+'/../static/img/posters/' + movie_data["imdbID"] + '.jpg')
		return db.movies.insert(movie_data)
	return

import time
import praw
from datetime import datetime
from pytz import timezone
import imdb as rrr
counter = 1
r = praw.Reddit(user_agent="fmoyt v1.0 by /u/yowmamasita")
r.login('ymsita', 'fmoytsita')
while 1:
	if counter == 3:
		r = praw.Reddit(user_agent="fmoyt v1.0 by /u/yowmamasita")
		r.login('ymsita', 'fmoytsita')
		counter = 0
	counter += 1
	fo = open("latestid.txt", "r")
	latestid = fo.read()
	fo.close()
	print "%s: latestid is %s" % (datetime.now(timezone('Asia/Manila')).strftime("%Y-%m-%d %H:%M:%S"), latestid)
	x_limit = 0
	y_limit = 0
	if len(latestid) > 0:
		submissions = r.get_subreddit("fullmoviesonyoutube").get_new(limit=1000, place_holder=latestid)
	else:
		submissions = r.get_subreddit("fullmoviesonyoutube").get_new(limit=1000)
	first = 1
	for x in submissions:
		if first == 1:
			first = 0
			fo = open("latestid.txt", "w")
			fo.write(x.id)
			fo.close()
		yt_id = get_yt_id(x.url)
		if yt_id is None:
			print "%s: Cant get youtube id of %s" % (datetime.now(timezone('Asia/Manila')).strftime("%Y-%m-%d %H:%M:%S"), x.title)
			continue
		yt = get_yt_params(yt_id)
		if yt is None:
			print "%s: Cant get youtube params of %s" % (datetime.now(timezone('Asia/Manila')).strftime("%Y-%m-%d %H:%M:%S"), x.title)
			continue
		imdb = get_imdb_url(x.title)
		if imdb is None:
			print "%s: Cant get imdb url of %s" % (datetime.now(timezone('Asia/Manila')).strftime("%Y-%m-%d %H:%M:%S"), x.title)
			time.sleep(2)
			imdb = get_imdb_url2(x.title)
			if imdb is None:
				print "%s: Cant get imdb url2 of %s" % (datetime.now(timezone('Asia/Manila')).strftime("%Y-%m-%d %H:%M:%S"), x.title)
				y_limit += 1
				if y_limit >= 100:
					print "%s: Breaking loop" % datetime.now(timezone('Asia/Manila')).strftime("%Y-%m-%d %H:%M:%S")
					break
				else:
					continue
		imdbx = get_imdb_params(imdb[1])
		if imdbx is None:
			print "%s: Cant get imdb params of %s" % (datetime.now(timezone('Asia/Manila')).strftime("%Y-%m-%d %H:%M:%S"), x.title)
			continue
		if imdbx["Response"] == "False":
		    continue
		if "N/A" in imdbx["imdbRating"]:
			imdbx["imdbRating"] = '0'
		if "N/A" in imdbx["imdbVotes"]:
			imdbx["imdbVotes"] = '0'
		mm =  rrr.IMDb(accessSystem='http')
		imdbf = mm.get_movie(imdbx["imdbID"].replace('tt', ''))
		try:
			imdbf["countries"]
		except KeyError:
			continue
		movie = {
			"redditId": x.id,
			"redditTitle": x.title,
			"redditUrl": x.url,
			"imdbUrl": imdb[0],
			"youtubeId": get_yt_id(x.url),
			"youtubeUrl": yt["watch"],
			"youtubeDuration": time.strftime("%H:%M:%S",time.gmtime(yt["duration"])),
			"moviePlot": imdbx["Plot"],
			"movieRated": imdbx["Rated"],
			"movieTitle": imdbx["Title"],
			"moviePoster": imdbx["Poster"],
			"movieWriter": imdbx["Writer"],
			"movieResponse": imdbx["Response"],
			"movieDirector": imdbx["Director"],
			"movieReleased": imdbx["Released"],
			"movieActors": imdbx["Actors"],
			"movieYear": int(imdbx["Year"]),
			"movieGenre": imdbx["Genre"],
			"movieRuntime": imdbx["Runtime"],
			"movieCountry": ', '.join(imdbf["countries"]),
			"movieType": imdbx["Type"],
			"imdbRating": float(imdbx["imdbRating"]),
			"imdbVotes": int(imdbx["imdbVotes"].replace(',', '')),
			"imdbID": imdbx["imdbID"]
		}
		if db_insert(movie) is None:
			print "%s: %s (%s) was not inserted" % (datetime.now(timezone('Asia/Manila')).strftime("%Y-%m-%d %H:%M:%S"), movie["movieTitle"], movie["redditId"])
			x_limit += 1
			if x_limit >= 100:
				print "%s: Breaking loop" % datetime.now(timezone('Asia/Manila')).strftime("%Y-%m-%d %H:%M:%S")
				break
		else:
			print "%s: %s (%s) is OK" % (datetime.now(timezone('Asia/Manila')).strftime("%Y-%m-%d %H:%M:%S"), movie["movieTitle"], movie["redditId"])
	time.sleep(600)
