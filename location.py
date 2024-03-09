import geocoder

def get_lat_long(location):
    g = geocoder.osm(location)
    return g.lat, g.lng

location = "1600 Amphitheatre Parkway, Mountain View, CA"
latitude, longitude = get_lat_long(location)
print(f"Latitude: {latitude}, Longitude: {longitude}")