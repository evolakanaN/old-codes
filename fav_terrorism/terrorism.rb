#-*- coding:utf-8 -*-

require "rubygems"
require "oauth"
require "uri"
require "json"
require "net/https"

consumer_key = OAuth::Consumer.new(
  '',
  '',
  {:site=>'http://twitter.com'}
)
access_token = OAuth::AccessToken.new(
  consumer_key,
  '',
  ''
)
class Array
    def include_some?(*args)
        self.any? {|i|
            args.include?(i)
        }
    end
end
class FavStream   
    def initialize(c_obj,a_obj)
        @consumer_key = c_obj
        @access_token = a_obj
    end
    def ignition
        uri = URI.parse("https://userstream.twitter.com/2/user.json")
        s = Net::HTTP.new(uri.host, uri.port)
        s.use_ssl = true
        s.verify_mode = OpenSSL::SSL::VERIFY_NONE
        s.start{|h|
            q = Net::HTTP::Get.new(uri.request_uri)
            q.oauth!(h, @consumer_key, @access_token)
            h.request(q){|r|
                r.read_body{|b|
                    data = JSON.parse(b) rescue next
                    yield data
                }
            }
        }
    end
    def fav(id)
        @access_token.post("/favourings/create/"+id.to_s+".json")
    end
    def destfav(id)
        @access_token.post("/statuses/destroy/"+id.to_s+".json")
    end
    def usage
        p "Usage:"
        p "   (fav): ruby terro.rb Sn0wNight"
        p "   (fav arr): ruby terro.rb [Sn0wNight,KOBA789]"
        p "   (fav+unfav+fav): ruby terro.rb -fuff Sn0wNight"
        p "   (fav+unfav+fav arr): ruby terro.rb -fuff [Sn0wNight,KOBA789]"
    end 
end
terro = FavStream.new(consumer_key,access_token)
if ARGV[0] == "-usage" then
    terro.usage
    exit 1
end
if ARGV[0] == "-fuff" && ARGV[1] != "" then
    if ARGV[1].start_with?("[") then
        arr = ARGV[1].split("[")[1].split("]")[0].split(",")
        terro.ignition {|st|
            if st["text"] then
                up = st["user"]
                if (up["screen_name"].to_a).include_some?(*arr) then
                    terro.fav(st["id"])
                    terro.destfav(st["id"])
                    terro.fav(st["id"])
                    p "[FAV+UNFAV+FAVED] : #{up['screen_name']} - #{st['text']}"
                end
            end
        }
    else
        terro.ignition{|st|
            if st["text"] then
                up = st["user"]
                if up["screen_name"] == ARGV[1] then
                    terro.fav(st["id"])
                    terro.destfav(st["id"])
                    terro.fav(st["id"])
                    terro.destfav(st["id"])
                    terro.fav(st["id"])
                    terro.destfav(st["id"])
                    terro.fav(st["id"])
                    p "[FAV+UNFAV+FAVED] : #{up['screen_name']} - #{st['text']}"
                end
            end
        }
    end
end
if ARGV[0] != "" && ARGV[0] != "-fuff" then
    if ARGV[0].start_with?("[") then
        arr = ARGV[0].split("[")[1].split("]")[0].split(",")
        terro.ignition{|st|
            if st["text"] then  
                up = st["user"]
                if (up["screen_name"].to_a).include_some?(*arr) then
                    terro.fav(st["id"])
                    p "[FAVED] : #{up['screen_name']} - #{st['text']}"
                end
            end
        }
    else
        terro.ignition{|st|
            if st["text"] then 
                up = st["user"]
                if up["screen_name"] == ARGV[0] then
                    terro.fav(st["id"])
                    p "[FAVED] : #{up['screen_name']} - #{st['text']}"
                end
            end
        }
    end
end