class LoginController < ApplicationController

  layout 'login'

  def login
     if request.post?
          @user = User.new( params[ :user ] )
          logged_in_user = @user.try_to_login
        if logged_in_user
        session[ :user_id ]  = logged_in_user.id
        session[ :email_address ]  = @user.email_address
        redirect_to(  :controller => :welcome  )
        session[:success] = "You are successfully logged in"+ logged_in_user.id.to_s 
       else
        session[:error] = "Invalid user/passord combination" 
       end
    end 
  end

  def logout
    flash[:notice ] = "Thank You for choosing SMSServerGui-2.0" 
    session[ :user_id ] = nil 
    reset_session
    redirect_to :action => :login
  end

end
